<?php

function itspublic_show_members( ) {

        $args = array(
        'posts_per_page' => -1,
        'post_type' => 'member',
        'post_status' => 'publish',
        );
        $my_query = null;
        $my_query = new WP_Query($args);
        $countMember = 0;

    ?>

    <?php if( $my_query->have_posts() ): ?>

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

                <div class="member-footer-info">
                    <div class="member-more-details">
                        <a href="#">+ More details</a>
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
    wp_reset_query();  ?>

<?php }

add_shortcode('itspublic_members', 'itspublic_show_members');