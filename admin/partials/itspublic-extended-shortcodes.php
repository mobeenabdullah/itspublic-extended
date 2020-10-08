<?php

// Members CPT Shortcode
function itspublic_show_members( ) {

    ob_start();

    $args = array(
        'posts_per_page' => -1,
        'post_type' => 'member',
        'post_status' => 'publish',
    );
    $my_query = null;
    $my_query = new WP_Query($args);
    $countMember = 0;

    if( $my_query->have_posts() ): ?>

        <div class="itspublic-members <?php if (wp_count_posts('member')->publish > 8) { echo 'itspublic-members-slider'; } ?>">

        <?php if (wp_count_posts('member')->publish > 8) { echo '<div>'; } ?>

        <?php while ($my_query->have_posts()) : $my_query->the_post(); ?>

            <?php $countMember++; ?>

            <div class="itspubic-single-member">

                <?php
                    $get_member_designation = rwmb_meta( 'itspublic-member_designation' );
                    $get_member_email = rwmb_meta( 'itspublic-member_email' );
                    $get_member_linkedin = rwmb_meta( 'itspublic-member_linkedin' );
                ?>

                <figure class="member-img">
                    <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                </figure>

                <h4 class="member-name"><?php the_title(); ?></h4>

                <h6 class="member-designation">
                    <?php echo $get_member_designation; ?>
                </h6>

                <div class="member-info">
                    <p><?php echo get_excerpt(); ?></p>
                </div>

                <div class="member-info-full" style="display: none;">
		            <?php the_content(); ?>
                </div>

                <div class="member-footer-info">
                    <div class="member-more-details">
                        <a href="#!">+ Meer detail</a>
                    </div>
                    <div class="member-social-icons">
                        <ul>
                            <li class="member-email">
                                <a href="mailto:<?php echo $get_member_email; ?>" target="_blank">
                                    <i class="fa fa-envelope"></i>
                                </a>
                            </li>
                            <li class="member-linkedin">
                                <a href="<?php echo $get_member_linkedin; ?>" target="_blank">
                                    <i class="fa fa-linkedin"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>

        <?php

            if ($countMember%8 == 0) {
                echo "</div><div>";
            }

            if (wp_count_posts('member')->publish == $countMember) {
                echo '</div>';
            }

        ?>

        <?php endwhile; ?>

        </div>

        <?php if (wp_count_posts('member')->publish > 8) : ?>
            <div class="custom-arrow-buttons"></div>
        <?php endif; ?>

    <?php endif;
    wp_reset_query();

    $content = ob_get_clean();
    return $content;

}

add_shortcode('itspublic_members', 'itspublic_show_members');

// Project CPT Shortcode
function itspublic_show_projects( ) {

    ob_start();

	echo '<div class="itspublic-projects">';

		$project_terms = get_terms( array(
			'taxonomy' => 'project_type',
			'hide_empty' => true,
		) );

		foreach ($project_terms as $project_term) {
			?>

            <div>

            <div class="<?php echo $project_term->slug; ?>">

                <div class="projecten__cover">

					<?php

					$product_args = array(
						'post_type'     => 'project',
						'orderby'      => 'id',
						'order'         => 'ASC',
						'post_status'   => 'publish',
						'tax_query' => array(
							array(
								'taxonomy'  => 'project_type',
								'terms'     => array( $project_term->slug ),
								'field'     => 'slug'
							)
						)
					);

					$product_list = new WP_Query ( $product_args );

					?>

					<?php while ( $product_list -> have_posts() ) : $product_list -> the_post(); ?>

                        <div class="projecten__single">
                            <figure class="projecten__single-img">
                                <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
                            </figure>

                            <div class="projecten__single-content">
                                <h4><?php the_title(); ?></h4>
	                            <?php the_excerpt(); ?>
                            </div>
                        </div>

					<?php endwhile; wp_reset_query(); ?>
                </div>

            </div>

        </div>

        <?php }

    echo '</div>';

	echo '<div class="projecten__arrows"></div>';

	$content = ob_get_clean();
	return $content;

}

add_shortcode('itspublic_projects', 'itspublic_show_projects');

// Project Type Term Shortcode
function itspublic_show_project_types() {

    ob_start();

	$project_terms = get_terms( array(
		'taxonomy' => 'project_type',
		'hide_empty' => true,
	) );

	echo '<div class="project_types_list">';
	foreach ($project_terms as $project_term) {
	    echo '<div>';
	    echo '<span class="project_type_btn '.$project_term->slug.'"><i class="fa ' . get_term_meta($project_term->term_id, 'type_icon', true) . '"></i><span> ' . $project_term->name . '</span></span>';
		echo '</div>';
	}
	echo '</div>';

	$content = ob_get_clean();
	return $content;

}

add_shortcode('itspublic_project_types', 'itspublic_show_project_types');

// Hero Search Form Shortcode
function itspublic_hero_search_form() {

	ob_start(); ?>

    <div class="searchbox__cover">
        <form action="http://itspublic.local/materialen/?ms=a" class="searchbox__cover-form" method="get">
            <div class="searchbox__cover-form--input">
                <input type="text" value="" class="search-input" id="search_field" placeholder="Doorzoek hier onze publicaties. Zoek bijvoorbeeld op 'onderwijs" />
                <button type="submit" class="search-btn">
                    <i class="fa fa-search"></i>
                </button>
                <img src="<?php echo plugin_dir_url( __FILE__ ) . '../../public/images/ajax-loader.gif'; ?>" class="quickSearchPreloader" alt="Loading">
            </div>
        </form>

        <!-- Result box -->
        <div id="searchResult">
            <div class="material__items search__items"></div>
        </div>
    </div>

	<?php

    $content = ob_get_clean();
	return $content;

}

add_shortcode('itspublic_hero_search_form', 'itspublic_hero_search_form');

// Materialen Page Shortcode
function itspublic_materialen_search_page() {

	ob_start(); ?>

    <!-- Filter Bar -->
    <div class="material__section">
        <div class="container">
            <div class="filter__box">
                <div class="filter__box-category">
                    <div class="custom__select">
                        <div class="trigger-box">
                            <?php

                                $args = array(
                                    'hide_empty' => false
                                );
                                $dropdownCategories = get_terms( 'categorie', $args );

                            ?>
                            <select class="custom__select-list" id="categories_dropdown_filter">
                                <option value="showall" selected="selected">Alle categorieën</option>
                                <?php

                                foreach ($dropdownCategories as $dropdownCategorie) { ?>
                                    <option value="<?php echo $dropdownCategorie->slug; ?>"><?php echo $dropdownCategorie->name; ?></option>
                                <?php }

                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="filter__box-or">
                    <span class="filter__box-or--box">Of</span>
                </div>
                <div class="filter__box-searchbox">
                    <div class="filter__search-cover">
                        <form action="#" id="searchForm" action="<?php echo esc_url( home_url('/') ); ?>" autocomplete="off">
                            <input type="text" name="s" id="materialenPageSearchInput" placeholder="Type hier uw zoekterm.">
                            <button type="button">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                            <img src="<?php echo plugin_dir_url( __FILE__ ) . '../../public/images/ajax-loader.gif'; ?>" class="materialenSearchPreloader" alt="Loading">
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Material Boxes and left sidebar -->
    <section class="itspublic__material-section">
        <div class="container">
            <div class="material__page">

                <!-- Material Sidebar Start -->
                <div class="material__page-sidebar">

	                <?php
                        $object = 'materiaal';
                        $output = 'objects';
                        $taxonomies = get_object_taxonomies( $object, $output );
                        $exclude = array( 'post_tag', 'post_format' );

                        if ( $taxonomies ) {

                            foreach ( $taxonomies  as $taxonomy ) {

                                if( in_array( $taxonomy->name, $exclude ) ) {
                                    continue;
                                }

                                $terms = get_terms($taxonomy->name, array(
                                    'hide_empty' => true,
                                    'orderby' => 'count',
                                    'order' => 'DESC'
                                ) );

                                if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) { ?>

                                    <!-- <?php echo $taxonomy->label; ?> Filter -->
                                    <div class="itspublic__sidebar-widget <?php echo strtolower($taxonomy->label); ?>">

                                        <!-- Filter Title -->
                                        <div class="itspublic__sidebar-title">
                                            <h4><?php echo $taxonomy->label; ?> <span class="filter-collapse-btn"><i class="fa fa-minus-square"></i></span></h4>
                                        </div>

                                        <!-- Filter List -->
                                        <div class="itspublic__sidebar-content">

                                            <?php

                                                foreach ( $terms as $term ) { ?>

                                                    <div class="filter__checkbox">
                                                        <div class="inputbox">
                                                            <label class="input-label">
                                                                <input type="checkbox" id="<?php echo $term->slug; ?>" class="filter_checkbox_field" value="<?php echo $term->slug; ?>">
                                                                <span class="checkmark"></span>
                                                            </label>
                                                        </div>
                                                        <label for="#<?php echo $term->slug; ?>"><?php echo $term->name; ?></label>
                                                        <span>(<?php echo $term->count; ?>)</span>
                                                    </div>

                                                <?php }

                                            ?>

                                        </div>

                                    </div>

                                <?php }

                            }

                        }
	                ?>

                </div>
                <!-- Material Sidebar End -->


                <!-- Material Items Start -->
                <div class="material__page-itemscover">
                    <div class="material__items">



                    </div>

                    <!-- Load More -->
                    <!-- <div class="material__page-btn">
                    <button type="button" class="material-btn">Load more <i class="fas fa-chevron-down"></i></button>
                    </div> -->
                    
                   
                <!-- Material Items end -->



            </div>
        </div>
    </section>

    <?php

	$content = ob_get_clean();
	return $content;

}

add_shortcode('itspublic_materialen_search', 'itspublic_materialen_search_page');