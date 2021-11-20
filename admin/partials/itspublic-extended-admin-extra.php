<?php

// Register New Image Sizes
add_image_size('materialen-hero', 165, 100, true);
add_image_size('materialen-card', 200, 115, true);
add_image_size('materialen-popup-half', 500, 125, true);
add_image_size('materialen-popup', 1030, 256, array('center', 'center'));
add_image_size('materialen-popup-top', 1010, 252, array('center', 'top'));
add_image_size('materialen-popup-bottom', 1020, 254, array('center', 'bottom'));
add_image_size('projects-slide-thumb', 210, 142, true);
add_image_size('home-hero-slider', 1600, 516, true);
add_image_size('home-team-thumb', 660, 332, true);
add_image_size('material-single-hero', 1600, 516, true);
add_image_size('material-single-team', 60, 60, true);
add_image_size('material-single-projects', 189, 126, true);

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
		'post_status' => 'publish',
	);
	$materiaal_query = null;
	$materiaal_query = new WP_Query($args);
	?>

	<?php if( $materiaal_query->have_posts() ): ?>

        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">

        <style type="text/css">
            .table-wrapper {
                max-width: 1110px;
                margin: 50px auto;
            }
            .dataTables_wrapper {
                padding: 20px;
                background-color: #FFFFFF;
            }
            .dataTables_length, .dataTables_filter {
                margin-bottom: 10px;
            }
            .dataTables_length select {
                width: 50px;
            }
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

        <div class="table-wrapper">

        <table class="rtable cell-border stripe">
            <thead>
            <tr>
                <th>Materiaal ID</th>
                <th>Materiaal Title</th>
                <th>Materiaal Slug</th>
                <th>Clicks (30 Days)</th>
                <th>Total Clicks</th>
            </tr>
            </thead>
            <tbody>

            <?php

            function clicks_x_days($getMateriaalStats, $days) {

	            $last_x_days = date('Y-m-d', time() - (60*60*24*$days));

	            $filter_days = array_filter($getMateriaalStats, function ($date)use($last_x_days){
		            return $date > $last_x_days;
	            });

	            return count($filter_days);
            }

            $materialen_stats_container = [];

            ?>

		<?php $sno_counter = 0; while ($materiaal_query->have_posts()) : $materiaal_query->the_post(); $sno_counter++ ?>

            <?php

			$getMateriaalStats = get_post_meta(get_the_ID(), 'materiaal_clicks', true);

			if ( ! $getMateriaalStats ) {
			    $getMateriaalStats = 0;
			}

            ?>

                <tr>
                    <td><?php the_ID(); ?></td>
                    <td><?php the_title(); ?></td>
                    <td><?php echo basename(get_permalink()); ?></td>
                    <td>
                        <?php echo clicks_x_days($getMateriaalStats, 30); ?>
                    </td>
                    <td><?php echo count($getMateriaalStats); ?></td>
                </tr>

		<?php endwhile; ?>

            </tbody>
        </table>

        </div>

        <?php

        ?>

        <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript">
            jQuery(document).ready(function() {
                jQuery('.rtable').DataTable({
                    "order": [[ 3, "desc" ]]
                });
            } );
        </script>

	<?php endif; wp_reset_query();  ?>


<?php }