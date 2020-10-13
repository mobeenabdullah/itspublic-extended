<?php

// Register New Image Sizes
add_image_size('materialen-hero', 165, 100, true);
add_image_size('materialen-card', 200, 115, true);
add_image_size('materialen-popup-half', 500, 125, true);
add_image_size('materialen-popup', 1030, 256, array('center', 'center'));
add_image_size('materialen-popup-top', 1010, 252, array('center', 'top'));
add_image_size('materialen-popup-bottom', 1020, 254, array('center', 'bottom'));

// Adding Stats Page
function itspublic_materialen_stats_page() {
	add_options_page('Materialen Stats', 'Materialen Stats', 'manage_options', 'materialen_stats', 'materialen_stats_page');
}
add_action('admin_menu', 'itspublic_materialen_stats_page');

function materialen_stats_page() { ?>

	<h2>Materialen Cards Stats</h2>
	<hr>

	<?php $args = array(
		'posts_per_page' => -1,
		'post_type' => 'materiaal',
		'post_status' => 'publish'
	);
	$materiaal_query = null;
	$materiaal_query = new WP_Query($args);
	?>

	<?php if( $materiaal_query->have_posts() ): ?>

        <style type="text/css">
            .rtable {
                display: inline-block;
                vertical-align: top;
                max-width: 100%;
                overflow-x: auto;
                white-space: nowrap;
                border-collapse: collapse;
                border-spacing: 0;
            }

            .rtable,
            .rtable--flip tbody {
                -webkit-overflow-scrolling: touch;
                background: #FFFFFF;
            }

            .rtable th {
                font-size: 14px;
                text-align: left;
                text-transform: uppercase;
                background: #f2f0e6;
            }

            .rtable th,
            .rtable td {
                padding: 10px 20px;
                border: 1px solid #d9d7ce;
            }
        </style>

        <table class="rtable">
            <thead>
            <tr>
                <th>S.No</th>
                <th>Materiaal ID</th>
                <th>Materiaal Title</th>
                <th>No. of Clicks</th>
            </tr>
            </thead>
            <tbody>

		<?php $sno_counter = 0; while ($materiaal_query->have_posts()) : $materiaal_query->the_post(); $sno_counter++ ?>

            <?php

			$getMateriaalStats = get_post_meta(get_the_ID(), 'materiaal_clicks', true);

			if ( ! $getMateriaalStats ) {
			    $getMateriaalStats = 0;
			}

            ?>

                <tr>
                    <td><?php echo $sno_counter; ?></td>
                    <td><?php the_ID(); ?></td>
                    <td><?php the_title(); ?></td>
                    <td><?php echo $getMateriaalStats; ?></td>
                </tr>

		<?php endwhile; ?>

            </tbody>
        </table>

	<?php endif; wp_reset_query();  ?>


<?php }