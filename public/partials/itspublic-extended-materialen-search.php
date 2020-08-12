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
                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title();?>">
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
                    <ul>
			            <?php $getWebLink = get_field('web_link');
			            if( $getWebLink ): ?>
                            <li>
                                <a href="<?php echo $getWebLink; ?>" class="icon-box" target="_blank"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/glob.svg" alt="Web Link"></a>
                            </li>
			            <?php endif; ?>
			            <?php $getPDF = get_field('pdf');
			            if( $getPDF ): ?>
                            <li>
                                <a href="<?php echo $getPDF['url']; ?>" class="icon-box" target="_blank"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/pdf.svg" alt="Download PDF"></a>
                            </li>
			            <?php endif; ?>
			            <?php $getPPT = get_field('ppt');
			            if( $getPPT ): ?>
                            <li>
                                <a href="<?php echo $getPPT['url']; ?>" class="icon-box" target="_blank"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/ppt.svg" alt="Download PPT"></a>
                            </li>
			            <?php endif; ?>
			            <?php $getExcel = get_field('excel');
			            if( $getExcel ): ?>
                            <li>
                                <a href="<?php echo $getExcel['url']; ?>" class="icon-box" target="_blank"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/excel.svg" alt="Download Excel"></a>
                            </li>
			            <?php endif; ?>
			            <?php $getWord = get_field('word');
			            if( $getWord ): ?>
                            <li>
                                <a href="<?php echo $getWord['url']; ?>" class="icon-box" target="_blank"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/word.svg" alt="Download Doc"></a>
                            </li>
			            <?php endif; ?>
	                    <?php $getFolder = get_field('folder');
	                    if( $getFolder ): ?>
                            <li>
                                <a href="<?php echo $getFolder; ?>" class="icon-box" target="_blank"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/folder.svg" alt="Download Doc"></a>
                            </li>
	                    <?php endif; ?>
                    </ul>
                </div>
                <div class="materialen-hidden-fields" style="display: none;">
                    <div class="img-url"><?php echo get_the_post_thumbnail_url(); ?></div>
                    <div class="materiaal-title"><?php the_title(); ?></div>
                    <div class="category-name"><?php echo $categorie_name; ?></div>
                    <div class="materiaal-content"><?php the_content(); ?></div>
                    <div class="materiaal-date"><?php echo $getDate; ?></div>
                    <div class="materiaal-weblink"><?php echo $getWebLink; ?></div>
                    <div class="materiaal-pdf"><?php echo $getPDF['url']; ?></div>
                    <div class="materiaal-ppt"><?php echo $getPPT['url']; ?></div>
                    <div class="materiaal-excel"><?php echo $getExcel['url']; ?></div>
                    <div class="materiaal-word"><?php echo $getWord['url']; ?></div>
                    <div class="materiaal-folder"><?php echo $getFolder; ?></div>
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
                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title();?>">
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
                    <ul>
	                    <?php $getWebLink = get_field('web_link');
	                    if( $getWebLink ): ?>
                            <li>
                                <a href="<?php echo $getWebLink; ?>" class="icon-box" target="_blank"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/glob.svg" alt="Web Link"></a>
                            </li>
	                    <?php endif; ?>
	                    <?php $getPDF = get_field('pdf');
	                    if( $getPDF ): ?>
                            <li>
                                <a href="<?php echo $getPDF['url']; ?>" class="icon-box" target="_blank"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/pdf.svg" alt="Download PDF"></a>
                            </li>
	                    <?php endif; ?>
	                    <?php $getPPT = get_field('ppt');
	                    if( $getPPT ): ?>
                            <li>
                                <a href="<?php echo $getPPT['url']; ?>" class="icon-box" target="_blank"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/ppt.svg" alt="Download PPT"></a>
                            </li>
	                    <?php endif; ?>
	                    <?php $getExcel = get_field('excel');
	                    if( $getExcel ): ?>
                            <li>
                                <a href="<?php echo $getExcel['url']; ?>" class="icon-box" target="_blank"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/excel.svg" alt="Download Excel"></a>
                            </li>
	                    <?php endif; ?>
	                    <?php $getWord = get_field('word');
	                    if( $getWord ): ?>
                            <li>
                                <a href="<?php echo $getWord['url']; ?>" class="icon-box" target="_blank"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/word.svg" alt="Download Doc"></a>
                            </li>
	                    <?php endif; ?>
	                    <?php $getFolder = get_field('folder');
	                    if( $getFolder ): ?>
                            <li>
                                <a href="<?php echo $getFolder; ?>" class="icon-box" target="_blank"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/folder.svg" alt="Download Doc"></a>
                            </li>
	                    <?php endif; ?>
                    </ul>
                </div>
                <div class="materialen-hidden-fields" style="display: none;">
                    <div class="img-url"><?php echo get_the_post_thumbnail_url(); ?></div>
                    <div class="materiaal-title"><?php the_title(); ?></div>
                    <div class="category-name"><?php echo $categorie_name; ?></div>
                    <div class="materiaal-content"><?php the_content(); ?></div>
                    <div class="materiaal-date"><?php echo $getDate; ?></div>
                    <div class="materiaal-weblink"><?php echo $getWebLink; ?></div>
                    <div class="materiaal-pdf"><?php echo $getPDF['url']; ?></div>
                    <div class="materiaal-ppt"><?php echo $getPPT['url']; ?></div>
                    <div class="materiaal-excel"><?php echo $getExcel['url']; ?></div>
                    <div class="materiaal-word"><?php echo $getWord['url']; ?></div>
                    <div class="materiaal-folder"><?php echo $getFolder; ?></div>
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
                        <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                    </a>
                </figure>
                <h4 class="item__single-title">
                    <a href="#!"><?php the_title(); ?></a>
                </h4>
                <div class="item__single-desc">
                    <?php the_excerpt(); ?>
                </div>

                <div class="materialen-hidden-fields" style="display: none;">
                    <div class="img-url"><?php echo get_the_post_thumbnail_url(); ?></div>
                    <div class="materiaal-title"><?php the_title(); ?></div>
                    <div class="category-name"><?php echo $categorie_name; ?></div>
                    <div class="materiaal-content"><?php the_content(); ?></div>
                    <div class="materiaal-date"><?php echo get_field('date'); ?></div>
                    <div class="materiaal-weblink"><?php echo get_field('web_link'); ?></div>
                    <div class="materiaal-pdf"><?php echo get_field('pdf'); ?></div>
                    <div class="materiaal-ppt"><?php echo get_field('ppt'); ?></div>
                    <div class="materiaal-excel"><?php echo get_field('excel'); ?></div>
                    <div class="materiaal-word"><?php echo get_field('word'); ?></div>
                    <div class="materiaal-folder"><?php echo get_field('folder'); ?></div>
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