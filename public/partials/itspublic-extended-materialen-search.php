<?php

// the ajax function
add_action('wp_ajax_data_fetch' , 'data_fetch');
add_action('wp_ajax_nopriv_data_fetch','data_fetch');
function data_fetch(){

	$the_query = new WP_Query(
		array(
			'posts_per_page' => 5,
			's' => esc_attr( $_POST['keyword'] ),
			'post_type' => 'materiaal',
			'tax_query' => array(
				array(
					'taxonomy' => 'categorie',
					'field' => 'slug',
					'terms' => array('methodieken', 'open-decks', 'over-its-public', 'projectinzichten', 'templates', 'training')
				),
				array(
					'taxonomy' => 'onderwerp',
					'field' => 'slug',
					'terms' => array('algemeen', 'beleid', 'covid-19', 'financieen', 'gemeentefinancien', 'klimaat-milieu', 'onderwijs', 'procesinrichting', 'werk-inkomen')
				),
				array(
					'taxonomy' => 'filetype',
					'field' => 'slug',
					'terms' => array('excel', 'google-sheets', 'ms-word', 'pdf', 'powerpoints')
				)
			)
		)
	);
	if( $the_query->have_posts() ) :
		while( $the_query->have_posts() ): $the_query->the_post(); ?>

			<h4><?php the_title();?></h4>

		<?php endwhile;
		wp_reset_postdata();
	else:
		echo '<h3>No Results Found</h3>';
	endif;

	die();
}

// add the ajax fetch js
add_action( 'wp_footer', 'ajax_fetch' );
function ajax_fetch() {
	?>

	<form method="get" id="searchForm" action="<?php echo esc_url( home_url('/') ); ?>" autocomplete="off">
		<input type="text" name="s" placeholder="Search" onkeyup="fetchResults()" id="searchInput">
		<select name="categorie" id="categorie">
			<option value="methodieken">Methodieken</option>
			<option value="open-decks">Open decks</option>
			<option value="over-its-public">Over it's public</option>
			<option value="projectinzichten">Projectinzichten</option>
			<option value="templates">Templates</option>
			<option value="training">Training</option>
		</select>
		<select name="onderwerp" id="onderwerp">
			<option value="algemeen">Algemeen</option>
			<option value="beleid">Beleid</option>
			<option value="covid-19">COVID-19</option>
			<option value="financieen">Financieën</option>
			<option value="gemeentefinancien">Gemeentefinanciën</option>
			<option value="algemeen">Algemeen</option>
			<option value="algemeen">Algemeen</option>
			<option value="algemeen">Algemeen</option>
			<option value="algemeen">Algemeen</option>
		</select>
	</form>

	<div id="datafetch"></div>

	<script type="text/javascript">

        function fetchResults(){

            var keyword = jQuery('#searchInput').val();

            console.log(keyword);

            if(keyword == ""){
                jQuery('#datafetch').html("");
            } else {
                jQuery.ajax({
                    url: '<?php echo admin_url('admin-ajax.php'); ?>',
                    type: 'post',
                    data: { action: 'data_fetch', keyword: keyword  },
                    success: function(data) {

                        console.log(data);

                        jQuery('#datafetch').html( data );
                    }
                });
            }


        }
	</script>

	<?php
}