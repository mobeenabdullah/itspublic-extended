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

            <!-- Single Item -->
            <div class="item__single">
                <figure class="item__single-img template-item hover-item">
                    <img src="http://itspublic.local/wp-content/plugins/itspublic-extended/admin/partials/../images/project-1.jpg" alt="">
                    <div class="cat-label">Templates</div>
                </figure>
                <h4 class="item__single-title"><?php the_title();?></h4>
                <div class="item__single-desc">
                    <?php the_excerpt(); ?>
                </div>
                <div class="item__single-footer">
                    <span class="date">June, 2020</span>
                    <ul>
                        <li>
                            <a href="#" class="icon-box"><img src="http://itspublic.local/wp-content/plugins/itspublic-extended/admin/partials/../images/glob.svg" alt=""></a>
                        </li>
                    </ul>
                </div>
            </div>

		<?php endwhile;
		wp_reset_postdata();
	else:
		echo '<h3>No Results Found</h3>';
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

                //print_r(get_the_terms(get_the_ID(), array( 'categorie')));

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
                    <span class="date">June, 2020</span>
                    <ul>
                        <li>
                            <a href="#" class="icon-box"><img src="http://itspublic.local/wp-content/plugins/itspublic-extended/admin/partials/../images/glob.svg" alt=""></a>
                        </li>
                    </ul>
                </div>
            </div>

		<?php endwhile;
		wp_reset_postdata();
	else:
		echo '<h3>No Results Found</h3>';
	endif;

	die();
}