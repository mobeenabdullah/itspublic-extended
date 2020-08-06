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

        <div class="itspublic-members">

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
                    <?php the_excerpt(); ?>
                </div>

                <div class="member-info-full" style="display: none;">
		            <?php the_content(); ?>
                </div>

                <div class="member-footer-info">
                    <div class="member-more-details">
                        <a href="#!">+ More details</a>
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
        <form action="" class="searchbox__cover-form">
            <div class="searchbox__cover-form--input">
                <input type="text" value="" class="search-input" id="search_field" placeholder="het primair" />
                <button type="button" class="search-btn" onclick="myFunction()">
                    Search
                </button>
            </div>
        </form>

        <!-- Result box -->
        <div id="searchResult">
            <div class="material__items search__items">
                <!-- Single Item -->
                <div class="item__single">
                    <figure class="item__single-img">
                        <a href="#">
                            <img src="<?php echo plugin_dir_url(__FILE__); ?>../images/project-1.jpg" alt="" />
                        </a>
                    </figure>
                    <h4 class="item__single-title">
                        <a href="#">Het optimale Bekostiging </a>
                    </h4>
                    <p class="item__single-desc">
                        Ons word template inclusief een andige werkinstructie en
                    </p>
                </div>

                <!-- Single Item -->
                <div class="item__single">
                    <figure class="item__single-img">
                        <a href="#">
                            <img src="<?php echo plugin_dir_url(__FILE__); ?>../images/project-2.jpg" alt="" />
                        </a>
                    </figure>
                    <h4 class="item__single-title">
                        <a href="#">Het optimale Bekostiging van</a>
                    </h4>
                    <p class="item__single-desc">
                        Ons word template inclusief een andige werkinstructie en een
                        voor
                    </p>
                </div>

                <!-- Single Item -->
                <div class="item__single">
                    <figure class="item__single-img">
                        <a href="#">
                            <img src="<?php echo plugin_dir_url(__FILE__); ?>../images/project-3.jpg" alt="" />
                        </a>
                    </figure>
                    <h4 class="item__single-title">
                        <a href="#"
                        >Het optimale Bekostiging van het primair onderwijs</a
                        >
                    </h4>
                    <p class="item__single-desc">
                        Ons word template inclusief een andige werkinstructie en een
                        voorbeeld
                    </p>
                </div>

                <!-- Single Item -->
                <div class="item__single">
                    <figure class="item__single-img">
                        <a href="#">
                            <img src="<?php echo plugin_dir_url(__FILE__); ?>../images/project-1.jpg" alt="" />
                        </a>
                    </figure>
                    <h4 class="item__single-title">
                        <a href="#">Het optimale Bekostiging van het</a>
                    </h4>
                    <p class="item__single-desc">
                        Ons word template inclusief een andige werkinstructie en een
                    </p>
                </div>

                <!-- Single Item -->
                <div class="item__single">
                    <figure class="item__single-img">
                        <a href="#">
                            <img src="<?php echo plugin_dir_url(__FILE__); ?>../images/project-2.jpg" alt="" />
                        </a>
                    </figure>
                    <h4 class="item__single-title">
                        <a href="#">Het optimale Bekostiging van het primair</a>
                    </h4>
                    <p class="item__single-desc">
                        Ons word template inclusief een andige werkinstructie en een
                        voorbeeld tabellenboek.
                    </p>
                </div>
            </div>

            <!-- Search filter and view all result button -->

            <div class="search__filters">
                <div class="search__filters-radiobuttons">
                    <label class="custom-radio"
                    >Materialen
                        <input type="radio" checked="checked" name="radio" />
                        <span class="checkmark"></span>
                    </label>
                    <label class="custom-radio"
                    >Slidesearch
                        <input type="radio" name="radio" />
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div class="search__filters-viewallresult">
                    <a href="#" class="search-btn">
                        View all result
                        <span class="viewbtn-arrow">
                    <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="13.23"
                            height="9.104"
                            viewBox="0 0 13.23 9.104"
                    >
                      <path
                              id="Path_1165"
                              data-name="Path 1165"
                              d="M13.05,46.033,9.113,42.1a.615.615,0,0,0-.87.87l2.887,2.887H.615a.615.615,0,1,0,0,1.23H11.129L8.243,49.97a.615.615,0,0,0,.87.87L13.05,46.9A.615.615,0,0,0,13.05,46.033Z"
                              transform="translate(0 -41.916)"
                              fill="#fff"
                      />
                    </svg>
                  </span>
                    </a>
                </div>
            </div>
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
                            <select class="custom__select-list">
                                <option disabled="disabled" selected="selected">select Categories</option>
                                <option value="saab">Saab</option>
                                <option value="vw">VW</option>
                                <option value="audi" selected>Audi</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="filter__box-or">
                    <span class="filter__box-or--box">or</span>
                </div>
                <div class="filter__box-searchbox">
                    <div class="filter__search-cover">
                        <form action="#">
                            <input type="text" id="search_field" placeholder="Type your keyword here for search....">
                            <button type="button">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
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

                    <!-- Single widget Onderwerp -->
                    <div class="itspublic__sidebar-widget">

                        <!-- Widget Title -->
                        <div class="itspublic__sidebar-title">
                            <h4>Onderwerp</h4>
                        </div>

                        <!-- Widget Content -->
                        <div class="itspublic__sidebar-content">
                            <!-- row -->
                            <div class="filter__checkbox">
                                <div class="inputbox">
                                    <label class="input-label">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <label for="vehicle1">Algemeen</label>
                                <span>(20)</span>
                            </div>

                            <!-- row -->
                            <div class="filter__checkbox">
                                <div class="inputbox">
                                    <label class="input-label">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <label for="vehicle1">Beleid</label>
                                <span>(20)</span>
                            </div>

                            <!-- row -->
                            <div class="filter__checkbox">
                                <div class="inputbox">
                                    <label class="input-label">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <label for="vehicle1">COVID-19</label>
                                <span>(20)</span>
                            </div>

                            <!-- row -->
                            <div class="filter__checkbox">
                                <div class="inputbox">
                                    <label class="input-label">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <label for="vehicle1"> Financieën</label>
                                <span>(20)</span>
                            </div>

                            <!-- row -->
                            <div class="filter__checkbox">
                                <div class="inputbox">
                                    <label class="input-label">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <label for="vehicle1">Gemeentefinanciën</label>
                                <span>(205)</span>
                            </div>

                            <!-- row -->
                            <div class="filter__checkbox">
                                <div class="inputbox">
                                    <label class="input-label">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <label for="vehicle1">Klimaat & Milieu</label>
                                <span>(20)</span>
                            </div>

                            <!-- row -->
                            <div class="filter__checkbox">
                                <div class="inputbox">
                                    <label class="input-label">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <label for="vehicle1">Onderwijs</label>
                                <span>(20)</span>
                            </div>

                            <!-- row -->
                            <div class="filter__checkbox">
                                <div class="inputbox">
                                    <label class="input-label">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <label for="vehicle1">Procesinrichting</label>
                                <span>(20)</span>
                            </div>

                            <!-- row -->
                            <div class="filter__checkbox">
                                <div class="inputbox">
                                    <label class="input-label">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <label for="vehicle1">Werk & inkomen</label>
                                <span>(20)</span>
                            </div>

                            <!-- row -->
                            <div class="filter__checkbox">
                                <div class="inputbox">
                                    <label class="input-label">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <label for="vehicle1">Gemeentefinanciën</label>
                                <span>(20)</span>
                            </div>

                            <div class="loadmore">
                                <a href="#" class="loadmore-btn">more...</a>
                            </div>
                        </div>
                    </div>

                    <!-- Single widget Categories -->
                    <div class="itspublic__sidebar-widget">

                        <!-- Widget Title -->
                        <div class="itspublic__sidebar-title">
                            <h4>Categories</h4>
                        </div>

                        <!-- Widget Content -->
                        <div class="itspublic__sidebar-content">
                            <!-- row -->
                            <div class="filter__checkbox">
                                <div class="inputbox">
                                    <label class="input-label">
                                        <input type="checkbox" checked="checked">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <label for="vehicle1">Methodieken</label>
                                <span>(20)</span>
                            </div>

                            <!-- row -->
                            <div class="filter__checkbox">
                                <div class="inputbox">
                                    <label class="input-label">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <label for="vehicle1">Open decks</label>
                                <span>(20)</span>
                            </div>

                            <!-- row -->
                            <div class="filter__checkbox">
                                <div class="inputbox">
                                    <label class="input-label">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <label for="vehicle1">Over it's public</label>
                                <span>(20)</span>
                            </div>

                            <!-- row -->
                            <div class="filter__checkbox">
                                <div class="inputbox">
                                    <label class="input-label">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <label for="vehicle1">Projectinzichten</label>
                                <span>(20)</span>
                            </div>

                            <!-- row -->
                            <div class="filter__checkbox">
                                <div class="inputbox">
                                    <label class="input-label">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <label for="vehicle1">Templates</label>
                                <span>(205)</span>
                            </div>

                            <!-- row -->
                            <div class="filter__checkbox">
                                <div class="inputbox">
                                    <label class="input-label">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <label for="vehicle1">Training</label>
                                <span>(20)</span>
                            </div>
                        </div>
                    </div>

                    <!-- Single widget Filetype -->
                    <div class="itspublic__sidebar-widget">

                        <!-- Widget Title -->
                        <div class="itspublic__sidebar-title">
                            <h4>Filetype</h4>
                        </div>

                        <!-- Widget Content -->
                        <div class="itspublic__sidebar-content">
                            <!-- row -->
                            <div class="filter__checkbox">
                                <div class="inputbox">
                                    <label class="input-label">
                                        <input type="checkbox" checked="checked">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <label for="vehicle1">Excel</label>
                                <span>(20)</span>
                            </div>

                            <!-- row -->
                            <div class="filter__checkbox">
                                <div class="inputbox">
                                    <label class="input-label">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <label for="vehicle1">Google Sheets</label>
                                <span>(20)</span>
                            </div>

                            <!-- row -->
                            <div class="filter__checkbox">
                                <div class="inputbox">
                                    <label class="input-label">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <label for="vehicle1">PowerPoints</label>
                                <span>(20)</span>
                            </div>

                            <!-- row -->
                            <div class="filter__checkbox">
                                <div class="inputbox">
                                    <label class="input-label">
                                        <input type="checkbox">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                                <label for="vehicle1">MS Word</label>
                                <span>(20)</span>
                            </div>


                        </div>
                    </div>

                </div>
                <!-- Material Sidebar End -->


                <!-- Material Items Start -->
                <div class="material__page-itemscover">
                    <div class="material__items">

                        <!-- Single Item -->
                        <div class="item__single">
                            <figure class="item__single-img template-item hover-item">
                                <img src="<?php echo plugin_dir_url(__FILE__); ?>../images/project-1.jpg" alt="">
                                <div class="cat-label">Templates</div>
                            </figure>
                            <h4 class="item__single-title">Portfoliomanagement in de Publieke sector</h4>
                            <p class="item__single-desc">
                                Ons word template inclusief een andige werkinstructie en een voorbeeld tabellenboek.
                            </p>
                            <div class="item__single-footer">
                                <span class="date">June, 2020</span>
                                <ul>
                                    <li>
                                        <a href="#" class="icon-box"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/glob.svg" alt=""></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Single Item -->
                        <div class="item__single">
                            <figure class="item__single-img opendocs-item hover-item">
                                <img src="<?php echo plugin_dir_url(__FILE__); ?>../images/project-1.jpg" alt="">
                                <div class="cat-label">Open decks</div>
                            </figure>
                            <h4 class="item__single-title">Portfoliomanagement in de Publieke sector</h4>
                            <p class="item__single-desc">
                                Ons word template inclusief een andige werkinstructie en een voorbeeld tabellenboek.
                            </p>
                            <div class="item__single-footer">
                                <span class="date">June, 2020</span>
                                <ul>
                                    <li>
                                        <a href="#" class="icon-box"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/glob.svg" alt="Visit website"></a>
                                        <a href="#" class="icon-box pdf-icon"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/pdf.svg"
                                                                                   alt="Download PDF File"></a>
                                        <a href="#" class="icon-box"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/ppt.svg"
                                                                          alt="Download PPT File"></a>
                                        <a href="#" class="icon-box"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/excel.svg"
                                                                          alt="Download Excel File"></a>
                                        <a href="#" class="icon-box"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/word.svg"
                                                                          alt="Download Word File"></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Single Item -->
                        <div class="item__single">
                            <figure class="item__single-img projectinzichten-item hover-item">
                                <img src="<?php echo plugin_dir_url(__FILE__); ?>../images/project-1.jpg" alt="">
                                <div class="cat-label">Projectinzichten</div>
                            </figure>
                            <h4 class="item__single-title">Portfoliomanagement in de Publieke sector</h4>
                            <p class="item__single-desc">
                                Ons word template inclusief een andige werkinstructie en een voorbeeld tabellenboek.
                            </p>
                            <div class="item__single-footer">
                                <span class="date">June, 2020</span>
                                <ul>
                                    <li>
                                        <a href="#" class="icon-box"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/glob.svg" alt=""></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Single Item -->
                        <div class="item__single">
                            <figure class="item__single-img training-item hover-item">
                                <img src="<?php echo plugin_dir_url(__FILE__); ?>../images/project-1.jpg" alt="">
                                <div class="cat-label">Training</div>
                            </figure>
                            <h4 class="item__single-title">Portfoliomanagement in de Publieke sector</h4>
                            <p class="item__single-desc">
                                Ons word template inclusief een andige werkinstructie en een voorbeeld tabellenboek.
                            </p>
                            <div class="item__single-footer">
                                <span class="date">June, 2020</span>
                                <ul>
                                    <li>
                                        <a href="#" class="icon-box"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/glob.svg" alt=""></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Single Item -->
                        <div class="item__single">
                            <figure class="item__single-img opendocs-item hover-item">
                                <img src="<?php echo plugin_dir_url(__FILE__); ?>../images/project-1.jpg" alt="">
                                <div class="cat-label">Open decks</div>
                            </figure>
                            <h4 class="item__single-title">Portfoliomanagement in de Publieke sector</h4>
                            <p class="item__single-desc">
                                Ons word template inclusief een andige werkinstructie en een voorbeeld tabellenboek.
                            </p>
                            <div class="item__single-footer">
                                <span class="date">June, 2020</span>
                                <ul>
                                    <li>
                                        <a href="#" class="icon-box"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/glob.svg" alt=""></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Single Item -->
                        <div class="item__single">
                            <figure class="item__single-img opendocs-item hover-item">
                                <img src="<?php echo plugin_dir_url(__FILE__); ?>../images/project-1.jpg" alt="">
                                <div class="cat-label">Open decks</div>
                            </figure>
                            <h4 class="item__single-title">Portfoliomanagement in de Publieke sector</h4>
                            <p class="item__single-desc">
                                Ons word template inclusief een andige werkinstructie en een voorbeeld tabellenboek.
                            </p>
                            <div class="item__single-footer">
                                <span class="date">June, 2020</span>
                                <ul>
                                    <li>
                                        <a href="#" class="icon-box"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/glob.svg" alt=""></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Single Item -->
                        <div class="item__single">
                            <figure class="item__single-img training-item hover-item">
                                <img src="<?php echo plugin_dir_url(__FILE__); ?>../images/project-1.jpg" alt="">
                                <div class="cat-label">Training</div>
                            </figure>
                            <h4 class="item__single-title">Portfoliomanagement in de Publieke sector</h4>
                            <p class="item__single-desc">
                                Ons word template inclusief een andige werkinstructie en een voorbeeld tabellenboek.
                            </p>
                            <div class="item__single-footer">
                                <span class="date">June, 2020</span>
                                <ul>
                                    <li>
                                        <a href="#" class="icon-box"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/glob.svg" alt=""></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Single Item -->
                        <div class="item__single">
                            <figure class="item__single-img training-item hover-item">
                                <img src="<?php echo plugin_dir_url(__FILE__); ?>../images/project-1.jpg" alt="">
                                <div class="cat-label">Training</div>
                            </figure>
                            <h4 class="item__single-title">Portfoliomanagement in de Publieke sector</h4>
                            <p class="item__single-desc">
                                Ons word template inclusief een andige werkinstructie en een voorbeeld tabellenboek
                                voorbeeld tabellenboek lfjsad
                            </p>
                            <div class="item__single-footer">
                                <span class="date">June, 2020</span>
                                <ul>
                                    <li>
                                        <a href="#" class="icon-box"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/glob.svg" alt=""></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Single Item -->
                        <div class="item__single">
                            <figure class="item__single-img opendocs-item hover-item">
                                <img src="<?php echo plugin_dir_url(__FILE__); ?>../images/project-1.jpg" alt="">
                                <div class="cat-label">Open decks</div>
                            </figure>
                            <h4 class="item__single-title">Portfoliomanagement in de Publieke sector</h4>
                            <p class="item__single-desc">
                                Ons word template inclusief een andige werkinstructie en een voorbeeld tabellenboek.
                            </p>
                            <div class="item__single-footer">
                                <span class="date">June, 2020</span>
                                <ul>
                                    <li>
                                        <a href="#" class="icon-box"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/glob.svg" alt=""></a>
                                        <a href="#" class="icon-box"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/pdf.svg" alt=""></a>
                                        <a href="#" class="icon-box"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/ppt.svg" alt=""></a>
                                        <a href="#" class="icon-box"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/excel.svg" alt=""></a>
                                        <a href="#" class="icon-box"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/word.svg" alt=""></a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Single Item -->
                        <div class="item__single">
                            <figure class="item__single-img template-item hover-item">
                                <img src="<?php echo plugin_dir_url(__FILE__); ?>../images/project-1.jpg" alt="">
                                <div class="cat-label">Templates</div>
                            </figure>
                            <h4 class="item__single-title">Portfoliomanagement in de Publieke sector</h4>
                            <p class="item__single-desc">
                                Ons word template inclusief een andige werkinstructie en een voorbeeld tabellenboek.
                            </p>
                            <div class="item__single-footer">
                                <span class="date">June, 2020</span>
                                <ul>
                                    <li>
                                        <a href="#" class="icon-box"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/glob.svg" alt=""></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Load More -->
                    <div class="material__page-btn">
                    <button type="button" class="material-btn">Load more <i class="fas fa-chevron-down"></i></button>
                    </div>
                    
                   
                <!-- Material Items end -->



            </div>
        </div>
    </section>

    <?php

	$content = ob_get_clean();
	return $content;

}

add_shortcode('itspublic_materialen_search', 'itspublic_materialen_search_page');