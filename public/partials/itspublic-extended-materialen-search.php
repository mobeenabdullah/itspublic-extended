<?php

// the ajax function
add_action('wp_ajax_data_fetch' , 'data_fetch');
add_action('wp_ajax_nopriv_data_fetch','data_fetch');
function data_fetch(){

    if (isset($_POST['getOnderwerpenSelected'])) {
	    $getOnderwerpen = $_POST['getOnderwerpenSelected'];
    } else {
	    $getOnderwerpen = $_POST['getOnderwerpen'];
    }

	if (isset($_POST['getCategorieenSelected'])) {
		$getCategorieen = $_POST['getCategorieenSelected'];
	} else {
		$getCategorieen = $_POST['getCategorieen'];
	}

	if (isset($_POST['getFiletypesSelected'])) {
		$getFiletypes = $_POST['getFiletypesSelected'];
	} else {
		$getFiletypes = $_POST['getFiletypes'];
	}

	$the_query = new WP_Query(
		array(
			'posts_per_page' => -1,
			's' => esc_attr( $_POST['keyword'] ),
			'post_type' => 'materiaal',
			'tax_query' => array(
				array(
					'taxonomy' => 'onderwerp',
					'field' => 'slug',
					'terms' => $getOnderwerpen
				),
				array(
					'taxonomy' => 'categorie',
					'field' => 'slug',
					'terms' => $getCategorieen
				),
				array(
					'taxonomy' => 'filetype',
					'field' => 'slug',
					'terms' => $getFiletypes
				)
			)
		)
	);

	if( $the_query->have_posts() ) :
		while( $the_query->have_posts() ): $the_query->the_post(); ?>

			<?php

			$categorie_terms = wp_get_post_terms(get_the_ID(), 'categorie', array( 'fields' => 'all' ));
			$first_categorie = array_values($categorie_terms)[0];
			$categorie_id = $first_categorie->term_id;
			$categorie_name = $first_categorie->name;

			$categorie_color = get_term_meta($categorie_id, 'categorie_color', true);

			?>

            <!-- Single Item -->
            <div class="item__single">
                <figure class="item__single-img template-item hover-item">
                    <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'materialen-card'); ?>" alt="<?php the_title();?>">
                    <div class="cat-label" style="background-color: <?php echo $categorie_color; ?> !important;"><?php echo $categorie_name; ?></div>
                </figure>
                <h4 class="item__single-title"><?php the_title();?></h4>
                <div class="item__single-desc">
                    <?php the_excerpt(); ?>
                </div>
                <div class="item__single-footer">
		            <?php  $getDate = get_field('date');
		            if( $getDate ): ?>
                        <span class="date"><?php echo $getDate; ?></span>
		            <?php endif; ?>

	                <?php $getAttachements = get_field('attachements'); ?>

                    <div class="item__single-attachements">
                        <ul>
			                <?php foreach ($getAttachements as $getAttachement) { ?>
                                <li>
					                <?php

					                $getDownloadLink = '';
					                $getFileType = $getAttachement['file_type'];

					                if ($getFileType === 'file') {
						                $getDownloadLink = $getAttachement['select_file'];
					                } elseif ($getFileType === 'link') {
						                $getDownloadLink = $getAttachement['external_link'];
					                }

					                ?>
                                    <a href="<?php echo $getDownloadLink ?>" class="icon-box" target="_blank">
                                        <img src="<?php echo $getAttachement['file_icon']; ?>" alt="Download">
                                    </a>
                                </li>
			                <?php } ?>
                        </ul>
                    </div>

                    <div class="item__single-members-list">
		                <?php $getMateriaalMembers = get_field('members'); ?>
                        <div class="itspublic__footer-avatar">
			                <?php foreach ($getMateriaalMembers as $getMateriaalMember) { ?>
                                <a href="#!" class="profile_img popoverbtn">
                                    <img src="<?php echo get_the_post_thumbnail_url($getMateriaalMember->ID); ?>" alt="<?php echo $getMateriaalMember->post_title; ?>" />
                                </a>
			                <?php } ?>
                        </div>
                        <!-- popover start -->
                        <div class="popoverbox">
                            <div class="persons__ul">
				                <?php foreach ($getMateriaalMembers as $getMateriaalMember) { ?>
                                    <li>
                                        <a href="#">
                                            <h5><?php echo $getMateriaalMember->post_title; ?></h5>
                                            <span class="person-email"><?php echo get_post_meta($getMateriaalMember->ID, 'itspublic-member_email', true);  ?></span>
                                        </a>
                                    </li>
				                <?php } ?>
                            </div>
                        </div>
                        <!-- popover end -->
                    </div>

                    <div class="information-box-wrapper">
                        <div class="information__box-cover">
                            <div class="content-text">
                                <p class="info-title">Maker: <?php echo get_field('maker'); ?></p>
                                <div class="license-info">
                                    Rechten:
                                    <div class="licenses-list-wrapper">
						                <?php $getMateriaalLicenses = get_field('license'); ?>
                                        <ul>
							                <?php foreach($getMateriaalLicenses as $getMateriaalLicense) { ?>
                                                <li>
                                                    <a href="<?php echo $getMateriaalLicense['license_link']; ?>" title="<?php echo $getMateriaalLicense['license_name']; ?>" target="_blank">
                                                        <img src="<?php echo $getMateriaalLicense['license_icon']; ?>" alt="<?php echo $getMateriaalLicense['license_name']; ?>">
                                                    </a>
                                                </li>
							                <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="content-btn">
                                <a href="<?php echo get_the_post_thumbnail_url(); ?>" class="info-btn full-img-download-btn" download>Download</a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="materialen-hidden-fields" style="display: none;">
                    <div class="img-url"><?php echo get_the_post_thumbnail_url(get_the_ID(), 'materialen-popup-half'); ?></div>
                    <div class="img-url-full"><?php echo get_the_post_thumbnail_url(); ?></div>
                    <div class="materiaal-title"><?php the_title(); ?></div>
                    <div class="category-name"><?php echo $categorie_name; ?></div>
                    <div class="materiaal-content"><?php the_content(); ?></div>
                    <div class="materiaal-date"><?php echo $getDate; ?></div>
                </div>
            </div>

		<?php endwhile;
		wp_reset_postdata();
	else:
		echo '<h3 class="materiaal-no-results">No Results Found</h3>';
	endif;

	die();
}

add_action('wp_ajax_data_fetch_all' , 'data_fetch_all');
add_action('wp_ajax_nopriv_data_fetch_all','data_fetch_all');
function data_fetch_all(){

	if (isset($_POST['getOnderwerpenSelected'])) {
		$getOnderwerpen = $_POST['getOnderwerpenSelected'];
	} else {
		$getOnderwerpen = $_POST['getOnderwerpen'];
	}

	if (isset($_POST['getCategorieenSelected'])) {
		$getCategorieen = $_POST['getCategorieenSelected'];
	} else {
		$getCategorieen = $_POST['getCategorieen'];
	}

	if (isset($_POST['getFiletypesSelected'])) {
		$getFiletypes = $_POST['getFiletypesSelected'];
	} else {
		$getFiletypes = $_POST['getFiletypes'];
	}

	$the_query = new WP_Query(
		array(
			'posts_per_page' => -1,
			'post_type' => 'materiaal',
			'tax_query' => array(
				array(
					'taxonomy' => 'onderwerp',
					'field' => 'slug',
					'terms' => $getOnderwerpen
				),
				array(
					'taxonomy' => 'categorie',
					'field' => 'slug',
					'terms' => $getCategorieen
				),
				array(
					'taxonomy' => 'filetype',
					'field' => 'slug',
					'terms' => $getFiletypes
				)
			)
		)
	);

	if( $the_query->have_posts() ) :
		while( $the_query->have_posts() ): $the_query->the_post(); ?>

			<?php

			    $categorie_terms = wp_get_post_terms(get_the_ID(), 'categorie', array( 'fields' => 'all' ));
			    $first_categorie = array_values($categorie_terms)[0];
			    $categorie_id = $first_categorie->term_id;
			    $categorie_name = $first_categorie->name;

			    $categorie_color = get_term_meta($categorie_id, 'categorie_color', true);

            ?>

            <!-- Single Item -->
            <div class="item__single">
                <figure class="item__single-img template-item hover-item">
                    <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'materialen-card'); ?>" alt="<?php the_title();?>">
                    <div class="cat-label" style="background-color: <?php echo $categorie_color; ?> !important;"><?php echo $categorie_name; ?></div>
                </figure>
                <h4 class="item__single-title"><?php the_title();?></h4>
                <div class="item__single-desc">
					<?php the_excerpt(); ?>
                </div>
                <div class="item__single-footer">
	                <?php  $getDate = get_field('date');
                    if( $getDate ): ?>
                        <span class="date"><?php echo $getDate; ?></span>
	                <?php endif; ?>

                    <?php $getAttachements = get_field('attachements'); ?>

                    <div class="item__single-attachements">
                        <ul>
		                    <?php foreach ($getAttachements as $getAttachement) { ?>
                                <li>
				                    <?php

				                    $getDownloadLink = '';
				                    $getFileType = $getAttachement['file_type'];

				                    if ($getFileType === 'file') {
					                    $getDownloadLink = $getAttachement['select_file'];
				                    } elseif ($getFileType === 'link') {
					                    $getDownloadLink = $getAttachement['external_link'];
				                    }

				                    ?>
                                    <a href="<?php echo $getDownloadLink ?>" class="icon-box" target="_blank">
                                        <img src="<?php echo $getAttachement['file_icon']; ?>" alt="Download">
                                    </a>
                                </li>
		                    <?php } ?>
                        </ul>
                    </div>

                    <div class="item__single-members-list">
	                    <?php $getMateriaalMembers = get_field('members'); ?>
                        <div class="itspublic__footer-avatar">
			                <?php foreach ($getMateriaalMembers as $getMateriaalMember) { ?>
                                <a href="#!" class="profile_img popoverbtn">
                                    <img src="<?php echo get_the_post_thumbnail_url($getMateriaalMember->ID); ?>" alt="<?php echo $getMateriaalMember->post_title; ?>" />
                                </a>
                            <?php } ?>
                        </div>
                        <!-- popover start -->
                        <div class="popoverbox">
                            <div class="persons__ul">
	                            <?php foreach ($getMateriaalMembers as $getMateriaalMember) { ?>
                                <li>
                                    <a href="#">
                                        <h5><?php echo $getMateriaalMember->post_title; ?></h5>
                                        <span class="person-email"><?php echo get_post_meta($getMateriaalMember->ID, 'itspublic-member_email', true);  ?></span>
                                    </a>
                                </li>
	                            <?php } ?>
                            </div>
                        </div>
                        <!-- popover end -->
                    </div>

                    <div class="information-box-wrapper">
                        <div class="information__box-cover">
                            <div class="content-text">
                                <p class="info-title">Maker: <?php echo get_field('maker'); ?></p>
                                <div class="license-info">
                                    Rechten:
                                    <div class="licenses-list-wrapper">
	                                    <?php $getMateriaalLicenses = get_field('license'); ?>
                                        <ul>
                                            <?php foreach($getMateriaalLicenses as $getMateriaalLicense) { ?>
                                                <li>
                                                    <a href="<?php echo $getMateriaalLicense['license_link']; ?>" title="<?php echo $getMateriaalLicense['license_name']; ?>" target="_blank">
                                                        <img src="<?php echo $getMateriaalLicense['license_icon']; ?>" alt="<?php echo $getMateriaalLicense['license_name']; ?>">
                                                    </a>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="content-btn">
                                <a href="<?php echo get_the_post_thumbnail_url(); ?>" class="info-btn full-img-download-btn" download>Download</a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="materialen-hidden-fields" style="display: none;">
                    <div class="img-url"><?php echo get_the_post_thumbnail_url(get_the_ID(), 'materialen-popup-half'); ?></div>
                    <div class="img-url-full"><?php echo get_the_post_thumbnail_url(); ?></div>
                    <div class="materiaal-title"><?php the_title(); ?></div>
                    <div class="category-name"><?php echo $categorie_name; ?></div>
                    <div class="materiaal-content"><?php the_content(); ?></div>
                    <div class="materiaal-date"><?php echo $getDate; ?></div>
                </div>
            </div>

		<?php endwhile;
		wp_reset_postdata();
	else:
		echo '<h3 class="materiaal-no-results">No Results Found</h3>';
	endif;

	die();
}

add_action('wp_ajax_data_fetch_hero' , 'data_fetch_hero');
add_action('wp_ajax_nopriv_data_fetch_hero','data_fetch_hero');
function data_fetch_hero(){

	$the_query = new WP_Query(
		array(
			'posts_per_page' => 5,
			's' => esc_attr( $_POST['keyword'] ),
			'post_type' => 'materiaal'
		)
	);

	echo '<div class="material__items search__items">';

	if( $the_query->have_posts() ) :
		while( $the_query->have_posts() ): $the_query->the_post(); ?>

			<?php

			$categorie_terms = wp_get_post_terms(get_the_ID(), 'categorie', array( 'fields' => 'all' ));
			$first_categorie = array_values($categorie_terms)[0];
			$categorie_name = $first_categorie->name;

			?>

            <!-- Single Item -->
            <div class="item__single">
                <figure class="item__single-img">
                    <a href="#!">
                    </a>
                        <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'materialen-hero'); ?>" alt="<?php the_title(); ?>">
                </figure>
                <h4 class="item__single-title">
                    <a href="#!"><?php the_title(); ?></a>
                </h4>
                <div class="item__single-desc">
                    <?php the_excerpt(); ?>
                </div>

                <div class="materialen-hidden-fields" style="display: none;">
                    <div class="img-url"><?php echo get_the_post_thumbnail_url(get_the_ID(), 'materialen-popup-half'); ?></div>
                    <div class="img-url-full"><?php echo get_the_post_thumbnail_url(); ?></div>
                    <div class="materiaal-title"><?php the_title(); ?></div>
                    <div class="category-name"><?php echo $categorie_name; ?></div>
                    <div class="materiaal-content"><?php the_content(); ?></div>
                    <div class="materiaal-date"><?php echo get_field('date'); ?></div>
                </div>

	            <?php $getAttachements = get_field('attachements'); ?>

                <div class="item__single-attachements">
                    <ul>
			            <?php foreach ($getAttachements as $getAttachement) { ?>
                            <li>
					            <?php

					            $getDownloadLink = '';
					            $getFileType = $getAttachement['file_type'];

					            if ($getFileType === 'file') {
						            $getDownloadLink = $getAttachement['select_file'];
					            } elseif ($getFileType === 'link') {
						            $getDownloadLink = $getAttachement['external_link'];
					            }

					            ?>
                                <a href="<?php echo $getDownloadLink ?>" class="icon-box" target="_blank">
                                    <img src="<?php echo $getAttachement['file_icon']; ?>" alt="Download">
                                </a>
                            </li>
			            <?php } ?>
                    </ul>
                </div>

                <div class="item__single-members-list">
		            <?php $getMateriaalMembers = get_field('members'); ?>
                    <div class="itspublic__footer-avatar">
			            <?php foreach ($getMateriaalMembers as $getMateriaalMember) { ?>
                            <a href="#!" class="profile_img popoverbtn">
                                <img src="<?php echo get_the_post_thumbnail_url($getMateriaalMember->ID); ?>" alt="<?php echo $getMateriaalMember->post_title; ?>" />
                            </a>
			            <?php } ?>
                    </div>
                    <!-- popover start -->
                    <div class="popoverbox">
                        <div class="persons__ul">
				            <?php foreach ($getMateriaalMembers as $getMateriaalMember) { ?>
                                <li>
                                    <a href="#">
                                        <h5><?php echo $getMateriaalMember->post_title; ?></h5>
                                        <span class="person-email"><?php echo get_post_meta($getMateriaalMember->ID, 'itspublic-member_email', true);  ?></span>
                                    </a>
                                </li>
				            <?php } ?>
                        </div>
                    </div>
                    <!-- popover end -->
                </div>

                <div class="information-box-wrapper">
                    <div class="information__box-cover">
                        <div class="content-text">
                            <p class="info-title">Maker: <?php echo get_field('maker'); ?></p>
                            <div class="license-info">
                                Rechten:
                                <div class="licenses-list-wrapper">
						            <?php $getMateriaalLicenses = get_field('license'); ?>
                                    <ul>
							            <?php foreach($getMateriaalLicenses as $getMateriaalLicense) { ?>
                                            <li>
                                                <a href="<?php echo $getMateriaalLicense['license_link']; ?>" title="<?php echo $getMateriaalLicense['license_name']; ?>" target="_blank">
                                                    <img src="<?php echo $getMateriaalLicense['license_icon']; ?>" alt="<?php echo $getMateriaalLicense['license_name']; ?>">
                                                </a>
                                            </li>
							            <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="content-btn">
                            <a href="<?php echo get_the_post_thumbnail_url(); ?>" class="info-btn full-img-download-btn" download>Download</a>
                        </div>
                    </div>
                </div>

            </div>

		<?php endwhile;
		wp_reset_postdata();
	else:
		echo '<h3 class="materiaal-no-results">No Results Found</h3>';
	endif;

	echo '</div>';

	die();
}

// Search based on Parameters in URL
function materialen_param_search() {
	if (isset($_GET['ms'])) { ?>
        <script>
            jQuery('#materialenPageSearchInput').val('<?php echo $_GET['ms']; ?>');
        </script>
	<?php }
}
add_action('wp_footer', 'materialen_param_search');

// Setting default value of Date field in ACF
add_filter('acf/load_field/name=date', 'my_acf_default_date');
function my_acf_default_date($field) {
	$field['default_value'] = date('Ymd');
	return $field;
}