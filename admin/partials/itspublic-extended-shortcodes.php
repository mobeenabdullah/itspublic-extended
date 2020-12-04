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
        <form action="<?php echo home_url(); ?>/materialen/?ms=a" class="searchbox__cover-form" method="get">
            <div class="searchbox__cover-form--input">
                <input type="text" value="" class="search-input" id="search_field" placeholder="Doorzoek hier onze publicaties. Zoek bijvoorbeeld op 'onderwijs'" />
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



// Materialen Single Page 
function itspublic_materialen_single() {

    ob_start(); 
    // Plugin Directory Url
    $plugins_url = plugin_dir_url( __DIR__ );  ?>

    

<section class="materialen__single" style="background-image: url('<?php echo $plugins_url ?>images/home-bg.png')">
        <div class="custom-container">
            <div class="materialen__single-header">
                <div class="information-wraper">
                    <div class="information__box-icon"><i class="fas fa-info-circle"></i></div>
                        <div class="information__box-content">
                            <div class="information__box-cover">
                                <div class="content-text">
                                    <p class="info-title">Fotograaf: Ann Fossa</p>
                                    <div class="license-info">
                                        Rechten:
                                        <div class="licenses-list-wrapper">
                                            <ul>
                                                <li>
                                                    <a href="#" target="_blank">
                                                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="64px" height="64px" viewBox="-0.5 0.5 64 64" enable-background="new -0.5 0.5 64 64" xml:space="preserve">
                                                            <g>
                                                                <circle fill="transparent" cx="31.325" cy="32.873" r="30.096"></circle>
                                                                <path id="text2809_1_" d="M31.5,14.08c-10.565,0-13.222,9.969-13.222,18.42c0,8.452,2.656,18.42,13.222,18.42
                                                                c10.564,0,13.221-9.968,13.221-18.42C44.721,24.049,42.064,14.08,31.5,14.08z M31.5,21.026c0.429,0,0.82,0.066,1.188,0.157
                                                                c0.761,0.656,1.133,1.561,0.403,2.823l-7.036,12.93c-0.216-1.636-0.247-3.24-0.247-4.437C25.808,28.777,26.066,21.026,31.5,21.026z
                                                                M36.766,26.987c0.373,1.984,0.426,4.056,0.426,5.513c0,3.723-0.258,11.475-5.69,11.475c-0.428,0-0.822-0.045-1.188-0.136
                                                                c-0.07-0.021-0.134-0.043-0.202-0.067c-0.112-0.032-0.23-0.068-0.336-0.11c-1.21-0.515-1.972-1.446-0.874-3.093L36.766,26.987z"></path>
                                                                <path id="path2815_1_" d="M31.433,0.5c-8.877,0-16.359,3.09-22.454,9.3c-3.087,3.087-5.443,6.607-7.082,10.532
                                                                C0.297,24.219-0.5,28.271-0.5,32.5c0,4.268,0.797,8.32,2.397,12.168c1.6,3.85,3.921,7.312,6.969,10.396
                                                                c3.085,3.049,6.549,5.399,10.398,7.037c3.886,1.602,7.939,2.398,12.169,2.398c4.229,0,8.34-0.826,12.303-2.465
                                                                c3.962-1.639,7.496-3.994,10.621-7.081c3.011-2.933,5.289-6.297,6.812-10.106C62.73,41,63.5,36.883,63.5,32.5
                                                                c0-4.343-0.77-8.454-2.33-12.303c-1.562-3.885-3.848-7.32-6.857-10.33C48.025,3.619,40.385,0.5,31.433,0.5z M31.567,6.259
                                                                c7.238,0,13.412,2.566,18.554,7.709c2.477,2.477,4.375,5.31,5.67,8.471c1.296,3.162,1.949,6.518,1.949,10.061
                                                                c0,7.354-2.516,13.454-7.506,18.33c-2.592,2.516-5.502,4.447-8.74,5.781c-3.2,1.334-6.498,1.994-9.927,1.994
                                                                c-3.468,0-6.788-0.653-9.949-1.948c-3.163-1.334-6.001-3.238-8.516-5.716c-2.515-2.514-4.455-5.353-5.826-8.516
                                                                c-1.333-3.199-2.017-6.498-2.017-9.927c0-3.467,0.684-6.787,2.017-9.949c1.371-3.2,3.312-6.074,5.826-8.628
                                                                C18.092,8.818,24.252,6.259,31.567,6.259z"></path>
                                                            </g>
                                                        </svg>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="content-btn">
                                    <a href="#" class="info-btn full-img-download-btn" download="">Download</a>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            
        </div>
</section>

<section class="materialen__details">
    <div class="custom-container">
        <div class="materialen__details-cover">
            <div class="materialen__details-cover--left">
                <div class="itspublic__popcontent">
                    <div class="taxonomies">
                        <ul>
                            <li class="materiaal-popup-date"><i class="far fa-calendar-alt"></i> <span>November, 2020</span></li>
                            <li class="materiaal-popup-categorie"><i class="fas fa-folder-open"></i> <span>Projectinzichten</span></li>
                        </ul>
                    </div>
                    <h3>Maatschappelijk vastgoed</h3>
                    <div class="popup_materiaal_content">
                        <p>Gemeenten hebben vastgoed in bezit voor gemeentelijke huisvesting, het realiseren van beleidsdoelstellingen en strategische doeleinden. Sinds de in werking treding van de Wet Markt en Overheid in 2012 zijn gemeenten verplicht om een huur te vragen die ten minste kostprijsdekkend is. Dit om marktverstoring te voorkomen en financiële stromen inzichtelijk te maken.<br><br>De berekening van deze kostprijs is onder andere afhankelijk van de keuzes die gemeenten maken in de berekening van de kapitaallasten en de verdeling van de beheerkosten.</p>
                        <p>In dit document worden de gevolgen van de keuzes met betrekking tot de beheerkosten en kapitaallasten voor de kostprijs van een<br>vastgoedobject aan de hand van eenvoudige rekenvoorbeelden geïllustreerd.</p>
                </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="materialen__details-cover--right">
               <div class="materialen__sidebar">

               <!-- Single widget -->
                   <div class="materialen__sidebar-widget">
                       <div class="materialen__sidebar-widget--title">
                            <h4>Download</h4>
                       </div>
                       <div class="materialen__sidebar-widget--content">         
                            <ul>
                                <li>
                                    <a href="#" class="icon-box" target="_blank">
                                        <img src="https://itspublicstagingfinal.local/wp-content/plugins/itspublic-extended/public/partials/../images/word.svg" alt="Download">
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="icon-box" target="_blank">
                                    <img src="https://itspublicstagingfinal.local/wp-content/plugins/itspublic-extended/public/partials/../images/word.svg" alt="Download">
                                    </a>
                                </li>                        
                            </ul>    
                        </div>
                       </div>
                   </div>

                   <div class="materialen__sidebar-widget">
                       <div class="materialen__sidebar-widget--title">
                            <h4>Het team</h4>
                       </div>
                       <div class="materialen__sidebar-widget--content">         
                            <ul>
                            <li class="team__member">
                                    <a href="#" target="_blank">
                                        <img src="https://itspublicstagingfinal.local/wp-content/uploads/2020/07/hugo-den-breejen-1.jpg" alt="Download">
                                    </a>
                                </li>
                                <li class="team__member">
                                    <a href="#" class="team__member" target="_blank">
                                    <img src="https://itspublicstagingfinal.local/wp-content/uploads/2020/07/kees-van-der-meeren-1.jpg" alt="Download">
                                    </a>
                                </li> 
                                                       
                            </ul>    
                        </div>
                       </div>
                   </div>



               </div>
            </div>


        </div>
    </div>
</div>
</section>

<section class="related__materialSec">
    <div class="custom-container">
        <div class="cat__title">
            <h3>Meer projections:</h3>
        </div>
        <div class="related__materialSec-items">
            <!-- Single Item -->
            <div class="item__single">
                <figure class="item__single-img">                
                    <img src="https://itspublicstagingfinal.local/wp-content/uploads/2020/11/Huizen2_Amsterdam_zero_ann-fossa2019-200x115.jpg" alt="">
                </figure>
                <h4 class="item__single-title">
                    <a href="#">Maatschappelijk vastgoed</a>
                </h4>
                <div class="item__single-desc">
                <p>Gemeenten hebben vastgoed in bezit voor gemeentelijke huisvesting, het realiseren van</p>
                </div>
            </div>

            <!-- Single Item -->
            <div class="item__single">
                <figure class="item__single-img">                
                    <img src="https://itspublicstagingfinal.local/wp-content/uploads/2020/11/Huizen2_Amsterdam_zero_ann-fossa2019-200x115.jpg" alt="">
                </figure>
                <h4 class="item__single-title">
                    <a href="#">Het optimale begeleidingsproces in de bijstand</a>
                </h4>
                <div class="item__single-desc">
                <p>Gemeenten hebben vastgoed in bezit voor gemeentelijke huisvesting, het realiseren van</p>
                </div>
            </div>

            <!-- Single Item -->
            <div class="item__single">
                <figure class="item__single-img">                
                    <img src="https://itspublicstagingfinal.local/wp-content/uploads/2020/11/Huizen2_Amsterdam_zero_ann-fossa2019-200x115.jpg" alt="">
                </figure>
                <h4 class="item__single-title">
                    <a href="#">Maatschappelijk vastgoed</a>
                </h4>
                <div class="item__single-desc">
                <p>Gemeenten hebben vastgoed in bezit voor gemeentelijke huisvesting, het realiseren van</p>
                </div>
            </div>

            <!-- Single Item -->
            <div class="item__single">
                <figure class="item__single-img">                
                    <img src="https://itspublicstagingfinal.local/wp-content/uploads/2020/11/Huizen2_Amsterdam_zero_ann-fossa2019-200x115.jpg" alt="">
                </figure>
                <h4 class="item__single-title">
                    <a href="#">Maatschappelijk vastgoed Het optimale begeleidingsproces in de bijstand</a>
                </h4>
                <div class="item__single-desc">
                <p>Gemeenten hebben vastgoed in bezit voor gemeentelijke huisvesting, het realiseren van</p>
                </div>
            </div>

            <!-- Single Item -->
            <div class="item__single">
                <figure class="item__single-img">                
                    <img src="https://itspublicstagingfinal.local/wp-content/uploads/2020/11/Huizen2_Amsterdam_zero_ann-fossa2019-200x115.jpg" alt="">
                </figure>
                <h4 class="item__single-title">
                    <a href="#">Maatschappelijk vastgoed</a>
                </h4>
                <div class="item__single-desc">
                <p>Gemeenten hebben vastgoed in bezit voor gemeentelijke huisvesting, het realiseren van</p>
                </div>
            </div>

            <!-- Single Item -->
            <div class="item__single">
                <figure class="item__single-img">                
                    <img src="https://itspublicstagingfinal.local/wp-content/uploads/2020/11/Huizen2_Amsterdam_zero_ann-fossa2019-200x115.jpg" alt="">
                </figure>
                <h4 class="item__single-title">
                    <a href="#">Maatschappelijk vastgoed</a>
                </h4>
                <div class="item__single-desc">
                <p>Gemeenten hebben vastgoed in bezit voor gemeentelijke huisvesting, het realiseren van</p>
                </div>
            </div>



        </div>
    </div>
</section>


<?php

$content = ob_get_clean();
return $content;

}

add_shortcode('itspublic_materialen_single', 'itspublic_materialen_single');  