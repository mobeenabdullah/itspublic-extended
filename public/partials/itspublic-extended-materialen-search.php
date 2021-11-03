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
			'meta_key' => 'date',
			'orderby' => 'meta_value',
			'order'   => 'DESC',
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

            $get_container_landing_page_status = get_field('open_container_landing_page');
            $get_container_landing_page_id = get_field('select_container_landing_page');

			?>

            <!-- Single Item -->
            <div class="item__single <?php if ($get_container_landing_page_status) echo 'disablePopup'; ?>">
                <figure class="item__single-img template-item hover-item">
	                <?php $getPhotoField = get_field('photo'); ?>
	                <?php if ($get_container_landing_page_status) : ?>
                        <a href="<?php echo get_the_permalink($get_container_landing_page_id); ?>">
                            <img src="<?php echo get_the_post_thumbnail_url($getPhotoField->ID, 'materialen-card'); ?>" alt="<?php the_title();?>">
                        </a>
	                <?php else : ?>
                        <img src="<?php echo get_the_post_thumbnail_url($getPhotoField->ID, 'materialen-card'); ?>" alt="<?php the_title();?>">
	                <?php endif; ?>
                    <div class="cat-label" style="background-color: <?php echo $categorie_color; ?> !important;"><?php echo $categorie_name; ?></div>
                </figure>

	            <?php if ($get_container_landing_page_status) : ?>
                    <a href="<?php echo get_the_permalink($get_container_landing_page_id); ?>">
                        <h4 class="item__single-title"><?php the_title();?> </h4>
                    </a>
                <?php else : ?>
                    <h4 class="item__single-title"><?php the_title();?> </h4>
                <?php endif; ?>

                <div class="item__single-desc">
	                <?php if ($get_container_landing_page_status) : ?>
                        <a href="<?php echo get_the_permalink($get_container_landing_page_id); ?>">
	                        <?php the_excerpt(); ?>
                        </a>
	                <?php else : ?>
		                <?php the_excerpt(); ?>
	                <?php endif; ?>
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
						                <?php
						                $getFileIconType = $getAttachement['file_icon'];
						                $getFileIconURL = '';
						                if ($getFileIconType == 'xls') {
							                $getFileIconURL = plugin_dir_url(__FILE__) . '../images/excel.svg';
						                } elseif ($getFileIconType == 'ppt') {
							                $getFileIconURL = plugin_dir_url(__FILE__) . '../images/ppt.svg';
						                } elseif ($getFileIconType == 'doc') {
							                $getFileIconURL = plugin_dir_url(__FILE__) . '../images/word.svg';
						                } elseif ($getFileIconType == 'pdf') {
							                $getFileIconURL = plugin_dir_url(__FILE__) . '../images/pdf.svg';
						                } elseif ($getFileIconType == 'link') {
							                $getFileIconURL = plugin_dir_url(__FILE__) . '../images/glob.svg';
						                } elseif ($getFileIconType == 'folder') {
							                $getFileIconURL = plugin_dir_url(__FILE__) . '../images/folder.svg';
						                }
						                ?>
                                        <img src="<?php echo $getFileIconURL; ?>" alt="Download">
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
                                <p class="info-title">Fotograaf: <?php echo get_field('maker', $getPhotoField->ID); ?></p>
                                <div class="license-info">
                                    Rechten:
                                    <div class="licenses-list-wrapper">
						                <?php $getAllRechten = get_field('rechten', $getPhotoField->ID); ?>
                                        <ul>
							                <?php foreach ($getAllRechten as $getSingleRechten) { ?>
                                                <li>
									                <?php $getRechtenValue = $getSingleRechten['value']; ?>

									                <?php if ($getRechtenValue == 'zero') { ?>

                                                        <a href="https://creativecommons.org/publicdomain/zero/1.0/deed.nl" target="_blank">
                                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                 width="64px" height="64px" viewBox="-0.5 0.5 64 64" enable-background="new -0.5 0.5 64 64" xml:space="preserve">
                                                            <g>
                                                                <circle fill="transparent" cx="31.325" cy="32.873" r="30.096"/>
                                                                <path id="text2809_1_" d="M31.5,14.08c-10.565,0-13.222,9.969-13.222,18.42c0,8.452,2.656,18.42,13.222,18.42
                                                                    c10.564,0,13.221-9.968,13.221-18.42C44.721,24.049,42.064,14.08,31.5,14.08z M31.5,21.026c0.429,0,0.82,0.066,1.188,0.157
                                                                    c0.761,0.656,1.133,1.561,0.403,2.823l-7.036,12.93c-0.216-1.636-0.247-3.24-0.247-4.437C25.808,28.777,26.066,21.026,31.5,21.026z
                                                                     M36.766,26.987c0.373,1.984,0.426,4.056,0.426,5.513c0,3.723-0.258,11.475-5.69,11.475c-0.428,0-0.822-0.045-1.188-0.136
                                                                    c-0.07-0.021-0.134-0.043-0.202-0.067c-0.112-0.032-0.23-0.068-0.336-0.11c-1.21-0.515-1.972-1.446-0.874-3.093L36.766,26.987z"/>
                                                                <path id="path2815_1_" d="M31.433,0.5c-8.877,0-16.359,3.09-22.454,9.3c-3.087,3.087-5.443,6.607-7.082,10.532
                                                                    C0.297,24.219-0.5,28.271-0.5,32.5c0,4.268,0.797,8.32,2.397,12.168c1.6,3.85,3.921,7.312,6.969,10.396
                                                                    c3.085,3.049,6.549,5.399,10.398,7.037c3.886,1.602,7.939,2.398,12.169,2.398c4.229,0,8.34-0.826,12.303-2.465
                                                                    c3.962-1.639,7.496-3.994,10.621-7.081c3.011-2.933,5.289-6.297,6.812-10.106C62.73,41,63.5,36.883,63.5,32.5
                                                                    c0-4.343-0.77-8.454-2.33-12.303c-1.562-3.885-3.848-7.32-6.857-10.33C48.025,3.619,40.385,0.5,31.433,0.5z M31.567,6.259
                                                                    c7.238,0,13.412,2.566,18.554,7.709c2.477,2.477,4.375,5.31,5.67,8.471c1.296,3.162,1.949,6.518,1.949,10.061
                                                                    c0,7.354-2.516,13.454-7.506,18.33c-2.592,2.516-5.502,4.447-8.74,5.781c-3.2,1.334-6.498,1.994-9.927,1.994
                                                                    c-3.468,0-6.788-0.653-9.949-1.948c-3.163-1.334-6.001-3.238-8.516-5.716c-2.515-2.514-4.455-5.353-5.826-8.516
                                                                    c-1.333-3.199-2.017-6.498-2.017-9.927c0-3.467,0.684-6.787,2.017-9.949c1.371-3.2,3.312-6.074,5.826-8.628
                                                                    C18.092,8.818,24.252,6.259,31.567,6.259z"/>
                                                            </g>
                                                        </svg>
                                                        </a>

									                <?php } elseif ($getRechtenValue == 'by-attribution') { ?>
                                                        <a href="https://creativecommons.org/licenses/by/4.0/deed.nl" target="_blank">
                                                            <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                 width="64px" height="64px" viewBox="5.5 -3.5 64 64" enable-background="new 5.5 -3.5 64 64" xml:space="preserve">
                                                            <g>
                                                                <circle fill="transparent" cx="37.637" cy="28.806" r="28.276"/>
                                                                <g>
                                                                    <path d="M37.443-3.5c8.988,0,16.57,3.085,22.742,9.257C66.393,11.967,69.5,19.548,69.5,28.5c0,8.991-3.049,16.476-9.145,22.456
                                                                        C53.879,57.319,46.242,60.5,37.443,60.5c-8.649,0-16.153-3.144-22.514-9.43C8.644,44.784,5.5,37.262,5.5,28.5
                                                                        c0-8.761,3.144-16.342,9.429-22.742C21.101-0.415,28.604-3.5,37.443-3.5z M37.557,2.272c-7.276,0-13.428,2.553-18.457,7.657
                                                                        c-5.22,5.334-7.829,11.525-7.829,18.572c0,7.086,2.59,13.22,7.77,18.398c5.181,5.182,11.352,7.771,18.514,7.771
                                                                        c7.123,0,13.334-2.607,18.629-7.828c5.029-4.838,7.543-10.952,7.543-18.343c0-7.276-2.553-13.465-7.656-18.571
                                                                        C50.967,4.824,44.795,2.272,37.557,2.272z M46.129,20.557v13.085h-3.656v15.542h-9.944V33.643h-3.656V20.557
                                                                        c0-0.572,0.2-1.057,0.599-1.457c0.401-0.399,0.887-0.6,1.457-0.6h13.144c0.533,0,1.01,0.2,1.428,0.6
                                                                        C45.918,19.5,46.129,19.986,46.129,20.557z M33.042,12.329c0-3.008,1.485-4.514,4.458-4.514s4.457,1.504,4.457,4.514
                                                                        c0,2.971-1.486,4.457-4.457,4.457S33.042,15.3,33.042,12.329z"/>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                        </a>
									                <?php } elseif ($getRechtenValue == 'by-attribution-No-derivative') {?>
                                                        <a href="https://creativecommons.org/licenses/by-nd/4.0/deed.nl" target="_blank">
                                                            <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                 width="64px" height="64px" viewBox="5.5 -3.5 64 64" enable-background="new 5.5 -3.5 64 64" xml:space="preserve">
                                                            <g>
                                                                <circle fill="transparent" cx="37.637" cy="28.806" r="28.276"/>
                                                                <g>
                                                                    <path d="M37.443-3.5c8.988,0,16.57,3.085,22.742,9.257C66.393,11.967,69.5,19.548,69.5,28.5c0,8.991-3.049,16.476-9.145,22.456
                                                                        C53.879,57.319,46.242,60.5,37.443,60.5c-8.649,0-16.153-3.144-22.514-9.43C8.644,44.784,5.5,37.262,5.5,28.5
                                                                        c0-8.761,3.144-16.342,9.429-22.742C21.101-0.415,28.604-3.5,37.443-3.5z M37.557,2.272c-7.276,0-13.428,2.553-18.457,7.657
                                                                        c-5.22,5.334-7.829,11.525-7.829,18.572c0,7.086,2.59,13.22,7.77,18.398c5.181,5.182,11.352,7.771,18.514,7.771
                                                                        c7.123,0,13.334-2.607,18.629-7.828c5.029-4.838,7.543-10.952,7.543-18.343c0-7.276-2.553-13.465-7.656-18.571
                                                                        C50.967,4.824,44.795,2.272,37.557,2.272z M46.129,20.557v13.085h-3.656v15.542h-9.944V33.643h-3.656V20.557
                                                                        c0-0.572,0.2-1.057,0.599-1.457c0.401-0.399,0.887-0.6,1.457-0.6h13.144c0.533,0,1.01,0.2,1.428,0.6
                                                                        C45.918,19.5,46.129,19.986,46.129,20.557z M33.042,12.329c0-3.008,1.485-4.514,4.458-4.514s4.457,1.504,4.457,4.514
                                                                        c0,2.971-1.486,4.457-4.457,4.457S33.042,15.3,33.042,12.329z"/>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                 width="64.000977px" height="64px" viewBox="0 0 64.000977 64" enable-background="new 0 0 64.000977 64" xml:space="preserve">
                                                            <g>
                                                                <circle fill="transparent" cx="32.064453" cy="31.788086" r="29.012695"/>
                                                                <g>
                                                                    <path d="M31.943848,0C40.896484,0,48.476562,3.105469,54.6875,9.314453C60.894531,15.486328,64.000977,23.045898,64.000977,32
                                                                        s-3.048828,16.457031-9.145508,22.513672C48.417969,60.837891,40.779297,64,31.942871,64
                                                                        c-8.648926,0-16.152832-3.142578-22.513672-9.429688C3.144043,48.286133,0,40.761719,0,32.000977
                                                                        c0-8.723633,3.144043-16.285156,9.429199-22.68457C15.640137,3.105469,23.14502,0,31.943848,0z M32.060547,5.771484
                                                                        c-7.275391,0-13.429688,2.570312-18.458496,7.714844C8.381836,18.783203,5.772949,24.954102,5.772949,32
                                                                        c0,7.125,2.589844,13.256836,7.77002,18.400391c5.181152,5.181641,11.352051,7.770508,18.515625,7.770508
                                                                        c7.123047,0,13.332031-2.608398,18.626953-7.828125C55.713867,45.466797,58.228516,39.353516,58.228516,32
                                                                        c0-7.3125-2.553711-13.484375-7.65625-18.513672C45.504883,8.341797,39.333984,5.771484,32.060547,5.771484z M44.117188,24.456055
                                                                        v5.485352H20.859863v-5.485352H44.117188z M44.117188,34.743164v5.481445H20.859863v-5.481445H44.117188z"/>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                        </a>
									                <?php } elseif ($getRechtenValue == 'by-attribution-Share-alike') {?>
                                                        <a href="https://creativecommons.org/licenses/by-sa/4.0/deed.nl" target="_blank">
                                                            <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                 width="64px" height="64px" viewBox="5.5 -3.5 64 64" enable-background="new 5.5 -3.5 64 64" xml:space="preserve">
                                                            <g>
                                                                <circle fill="transparent" cx="37.637" cy="28.806" r="28.276"/>
                                                                <g>
                                                                    <path d="M37.443-3.5c8.988,0,16.57,3.085,22.742,9.257C66.393,11.967,69.5,19.548,69.5,28.5c0,8.991-3.049,16.476-9.145,22.456
                                                                        C53.879,57.319,46.242,60.5,37.443,60.5c-8.649,0-16.153-3.144-22.514-9.43C8.644,44.784,5.5,37.262,5.5,28.5
                                                                        c0-8.761,3.144-16.342,9.429-22.742C21.101-0.415,28.604-3.5,37.443-3.5z M37.557,2.272c-7.276,0-13.428,2.553-18.457,7.657
                                                                        c-5.22,5.334-7.829,11.525-7.829,18.572c0,7.086,2.59,13.22,7.77,18.398c5.181,5.182,11.352,7.771,18.514,7.771
                                                                        c7.123,0,13.334-2.607,18.629-7.828c5.029-4.838,7.543-10.952,7.543-18.343c0-7.276-2.553-13.465-7.656-18.571
                                                                        C50.967,4.824,44.795,2.272,37.557,2.272z M46.129,20.557v13.085h-3.656v15.542h-9.944V33.643h-3.656V20.557
                                                                        c0-0.572,0.2-1.057,0.599-1.457c0.401-0.399,0.887-0.6,1.457-0.6h13.144c0.533,0,1.01,0.2,1.428,0.6
                                                                        C45.918,19.5,46.129,19.986,46.129,20.557z M33.042,12.329c0-3.008,1.485-4.514,4.458-4.514s4.457,1.504,4.457,4.514
                                                                        c0,2.971-1.486,4.457-4.457,4.457S33.042,15.3,33.042,12.329z"/>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                            <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                 width="64px" height="64px" viewBox="5.5 -3.5 64 64" enable-background="new 5.5 -3.5 64 64" xml:space="preserve">
                                                            <g>
                                                                <circle fill="transparent" cx="36.944" cy="28.631" r="29.105"/>
                                                                <g>
                                                                    <path d="M37.443-3.5c8.951,0,16.531,3.105,22.742,9.315C66.393,11.987,69.5,19.548,69.5,28.5c0,8.954-3.049,16.457-9.145,22.514
                                                                        C53.918,57.338,46.279,60.5,37.443,60.5c-8.649,0-16.153-3.143-22.514-9.429C8.644,44.786,5.5,37.264,5.5,28.501
                                                                        c0-8.723,3.144-16.285,9.429-22.685C21.138-0.395,28.643-3.5,37.443-3.5z M37.557,2.272c-7.276,0-13.428,2.572-18.457,7.715
                                                                        c-5.22,5.296-7.829,11.467-7.829,18.513c0,7.125,2.59,13.257,7.77,18.4c5.181,5.182,11.352,7.771,18.514,7.771
                                                                        c7.123,0,13.334-2.609,18.629-7.828c5.029-4.876,7.543-10.99,7.543-18.343c0-7.313-2.553-13.485-7.656-18.513
                                                                        C51.004,4.842,44.832,2.272,37.557,2.272z M23.271,23.985c0.609-3.924,2.189-6.962,4.742-9.114
                                                                        c2.552-2.152,5.656-3.228,9.314-3.228c5.027,0,9.029,1.62,12,4.856c2.971,3.238,4.457,7.391,4.457,12.457
                                                                        c0,4.915-1.543,9-4.627,12.256c-3.088,3.256-7.086,4.886-12.002,4.886c-3.619,0-6.743-1.085-9.371-3.257
                                                                        c-2.629-2.172-4.209-5.257-4.743-9.257H31.1c0.19,3.886,2.533,5.829,7.029,5.829c2.246,0,4.057-0.972,5.428-2.914
                                                                        c1.373-1.942,2.059-4.534,2.059-7.771c0-3.391-0.629-5.971-1.885-7.743c-1.258-1.771-3.066-2.657-5.43-2.657
                                                                        c-4.268,0-6.667,1.885-7.2,5.656h2.343l-6.342,6.343l-6.343-6.343L23.271,23.985L23.271,23.985z"/>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                        </a>
									                <?php } elseif ($getRechtenValue == 'by-attribution-nonCommercial-ShareAlike') {?>
                                                        <a href="https://creativecommons.org/licenses/by-nc-sa/4.0/deed.nl" target="_blank">
                                                            <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                 width="64px" height="64px" viewBox="5.5 -3.5 64 64" enable-background="new 5.5 -3.5 64 64" xml:space="preserve">
                                                                <g>
                                                                    <circle fill="transparent" cx="37.785" cy="28.501" r="28.836"/>
                                                                    <path d="M37.441-3.5c8.951,0,16.572,3.125,22.857,9.372c3.008,3.009,5.295,6.448,6.857,10.314
                                                                        c1.561,3.867,2.344,7.971,2.344,12.314c0,4.381-0.773,8.486-2.314,12.313c-1.543,3.828-3.82,7.21-6.828,10.143
                                                                        c-3.123,3.085-6.666,5.448-10.629,7.086c-3.961,1.638-8.057,2.457-12.285,2.457s-8.276-0.808-12.143-2.429
                                                                        c-3.866-1.618-7.333-3.961-10.4-7.027c-3.067-3.066-5.4-6.524-7-10.372S5.5,32.767,5.5,28.5c0-4.229,0.809-8.295,2.428-12.2
                                                                        c1.619-3.905,3.972-7.4,7.057-10.486C21.08-0.394,28.565-3.5,37.441-3.5z M37.557,2.272c-7.314,0-13.467,2.553-18.458,7.657
                                                                        c-2.515,2.553-4.448,5.419-5.8,8.6c-1.354,3.181-2.029,6.505-2.029,9.972c0,3.429,0.675,6.734,2.029,9.913
                                                                        c1.353,3.183,3.285,6.021,5.8,8.516c2.514,2.496,5.351,4.399,8.515,5.715c3.161,1.314,6.476,1.971,9.943,1.971
                                                                        c3.428,0,6.75-0.665,9.973-1.999c3.219-1.335,6.121-3.257,8.713-5.771c4.99-4.876,7.484-10.99,7.484-18.344
                                                                        c0-3.543-0.648-6.895-1.943-10.057c-1.293-3.162-3.18-5.98-5.654-8.458C50.984,4.844,44.795,2.272,37.557,2.272z M37.156,23.187
                                                                        l-4.287,2.229c-0.458-0.951-1.019-1.619-1.685-2c-0.667-0.38-1.286-0.571-1.858-0.571c-2.856,0-4.286,1.885-4.286,5.657
                                                                        c0,1.714,0.362,3.084,1.085,4.113c0.724,1.029,1.791,1.544,3.201,1.544c1.867,0,3.181-0.915,3.944-2.743l3.942,2
                                                                        c-0.838,1.563-2,2.791-3.486,3.686c-1.484,0.896-3.123,1.343-4.914,1.343c-2.857,0-5.163-0.875-6.915-2.629
                                                                        c-1.752-1.752-2.628-4.19-2.628-7.313c0-3.048,0.886-5.466,2.657-7.257c1.771-1.79,4.009-2.686,6.715-2.686
                                                                        C32.604,18.558,35.441,20.101,37.156,23.187z M55.613,23.187l-4.229,2.229c-0.457-0.951-1.02-1.619-1.686-2
                                                                        c-0.668-0.38-1.307-0.571-1.914-0.571c-2.857,0-4.287,1.885-4.287,5.657c0,1.714,0.363,3.084,1.086,4.113
                                                                        c0.723,1.029,1.789,1.544,3.201,1.544c1.865,0,3.18-0.915,3.941-2.743l4,2c-0.875,1.563-2.057,2.791-3.541,3.686
                                                                        c-1.486,0.896-3.105,1.343-4.857,1.343c-2.896,0-5.209-0.875-6.941-2.629c-1.736-1.752-2.602-4.19-2.602-7.313
                                                                        c0-3.048,0.885-5.466,2.658-7.257c1.77-1.79,4.008-2.686,6.713-2.686C51.117,18.558,53.938,20.101,55.613,23.187z"/>
                                                                </g>
                                                            </svg>
                                                            <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                 width="64px" height="64px" viewBox="5.5 -3.5 64 64" enable-background="new 5.5 -3.5 64 64" xml:space="preserve">
                                                                <g>
                                                                    <circle fill="transparent" cx="37.637" cy="28.806" r="28.276"/>
                                                                    <g>
                                                                        <path d="M37.443-3.5c8.988,0,16.57,3.085,22.742,9.257C66.393,11.967,69.5,19.548,69.5,28.5c0,8.991-3.049,16.476-9.145,22.456
                                                                            C53.879,57.319,46.242,60.5,37.443,60.5c-8.649,0-16.153-3.144-22.514-9.43C8.644,44.784,5.5,37.262,5.5,28.5
                                                                            c0-8.761,3.144-16.342,9.429-22.742C21.101-0.415,28.604-3.5,37.443-3.5z M37.557,2.272c-7.276,0-13.428,2.553-18.457,7.657
                                                                            c-5.22,5.334-7.829,11.525-7.829,18.572c0,7.086,2.59,13.22,7.77,18.398c5.181,5.182,11.352,7.771,18.514,7.771
                                                                            c7.123,0,13.334-2.607,18.629-7.828c5.029-4.838,7.543-10.952,7.543-18.343c0-7.276-2.553-13.465-7.656-18.571
                                                                            C50.967,4.824,44.795,2.272,37.557,2.272z M46.129,20.557v13.085h-3.656v15.542h-9.944V33.643h-3.656V20.557
                                                                            c0-0.572,0.2-1.057,0.599-1.457c0.401-0.399,0.887-0.6,1.457-0.6h13.144c0.533,0,1.01,0.2,1.428,0.6
                                                                            C45.918,19.5,46.129,19.986,46.129,20.557z M33.042,12.329c0-3.008,1.485-4.514,4.458-4.514s4.457,1.504,4.457,4.514
                                                                            c0,2.971-1.486,4.457-4.457,4.457S33.042,15.3,33.042,12.329z"/>
                                                                    </g>
                                                                </g>
                                                            </svg>
                                                            <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                 width="64px" height="64px" viewBox="5.5 -3.5 64 64" enable-background="new 5.5 -3.5 64 64" xml:space="preserve">
                                                                <g>
                                                                    <circle fill="transparent" cx="37.47" cy="28.736" r="29.471"/>
                                                                    <g>
                                                                        <path d="M37.442-3.5c8.99,0,16.571,3.085,22.743,9.256C66.393,11.928,69.5,19.509,69.5,28.5c0,8.992-3.048,16.476-9.145,22.458
                                                                            C53.88,57.32,46.241,60.5,37.442,60.5c-8.686,0-16.19-3.162-22.513-9.485C8.644,44.728,5.5,37.225,5.5,28.5
                                                                            c0-8.762,3.144-16.343,9.429-22.743C21.1-0.414,28.604-3.5,37.442-3.5z M12.7,19.872c-0.952,2.628-1.429,5.505-1.429,8.629
                                                                            c0,7.086,2.59,13.22,7.77,18.4c5.219,5.144,11.391,7.715,18.514,7.715c7.201,0,13.409-2.608,18.63-7.829
                                                                            c1.867-1.79,3.332-3.657,4.398-5.602l-12.056-5.371c-0.421,2.02-1.439,3.667-3.057,4.942c-1.622,1.276-3.535,2.011-5.744,2.2
                                                                            v4.915h-3.714v-4.915c-3.543-0.036-6.782-1.312-9.714-3.827l4.4-4.457c2.094,1.942,4.476,2.913,7.143,2.913
                                                                            c1.104,0,2.048-0.246,2.83-0.743c0.78-0.494,1.172-1.312,1.172-2.457c0-0.801-0.287-1.448-0.858-1.943l-3.085-1.315l-3.771-1.715
                                                                            l-5.086-2.229L12.7,19.872z M37.557,2.214c-7.276,0-13.428,2.571-18.457,7.714c-1.258,1.258-2.439,2.686-3.543,4.287L27.786,19.7
                                                                            c0.533-1.676,1.542-3.019,3.029-4.028c1.484-1.009,3.218-1.571,5.2-1.686V9.071h3.715v4.915c2.934,0.153,5.6,1.143,8,2.971
                                                                            l-4.172,4.286c-1.793-1.257-3.619-1.885-5.486-1.885c-0.991,0-1.876,0.191-2.656,0.571c-0.781,0.381-1.172,1.029-1.172,1.943
                                                                            c0,0.267,0.095,0.533,0.285,0.8l4.057,1.83l2.8,1.257l5.144,2.285l16.397,7.314c0.535-2.248,0.801-4.533,0.801-6.857
                                                                            c0-7.353-2.552-13.543-7.656-18.573C51.005,4.785,44.831,2.214,37.557,2.214z"/>
                                                                    </g>
                                                                </g>
                                                            </svg>
                                                            <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                 width="64px" height="64px" viewBox="5.5 -3.5 64 64" enable-background="new 5.5 -3.5 64 64" xml:space="preserve">
                                                                <g>
                                                                    <circle fill="transparent" cx="36.944" cy="28.631" r="29.105"/>
                                                                    <g>
                                                                        <path d="M37.443-3.5c8.951,0,16.531,3.105,22.742,9.315C66.393,11.987,69.5,19.548,69.5,28.5c0,8.954-3.049,16.457-9.145,22.514
                                                                            C53.918,57.338,46.279,60.5,37.443,60.5c-8.649,0-16.153-3.143-22.514-9.429C8.644,44.786,5.5,37.264,5.5,28.501
                                                                            c0-8.723,3.144-16.285,9.429-22.685C21.138-0.395,28.643-3.5,37.443-3.5z M37.557,2.272c-7.276,0-13.428,2.572-18.457,7.715
                                                                            c-5.22,5.296-7.829,11.467-7.829,18.513c0,7.125,2.59,13.257,7.77,18.4c5.181,5.182,11.352,7.771,18.514,7.771
                                                                            c7.123,0,13.334-2.609,18.629-7.828c5.029-4.876,7.543-10.99,7.543-18.343c0-7.313-2.553-13.485-7.656-18.513
                                                                            C51.004,4.842,44.832,2.272,37.557,2.272z M23.271,23.985c0.609-3.924,2.189-6.962,4.742-9.114
                                                                            c2.552-2.152,5.656-3.228,9.314-3.228c5.027,0,9.029,1.62,12,4.856c2.971,3.238,4.457,7.391,4.457,12.457
                                                                            c0,4.915-1.543,9-4.627,12.256c-3.088,3.256-7.086,4.886-12.002,4.886c-3.619,0-6.743-1.085-9.371-3.257
                                                                            c-2.629-2.172-4.209-5.257-4.743-9.257H31.1c0.19,3.886,2.533,5.829,7.029,5.829c2.246,0,4.057-0.972,5.428-2.914
                                                                            c1.373-1.942,2.059-4.534,2.059-7.771c0-3.391-0.629-5.971-1.885-7.743c-1.258-1.771-3.066-2.657-5.43-2.657
                                                                            c-4.268,0-6.667,1.885-7.2,5.656h2.343l-6.342,6.343l-6.343-6.343L23.271,23.985L23.271,23.985z"/>
                                                                    </g>
                                                                </g>
                                                            </svg>
                                                        </a>
									                <?php } ?>

                                                </li>
							                <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="content-btn">
                                <a href="<?php echo get_the_post_thumbnail_url($getPhotoField->ID, 'full'); ?>" class="info-btn full-img-download-btn" download>Download</a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="materialen-hidden-fields" style="display: none;">
                    <?php
                        $popup_photo_size = '';
                        $get_popup_photo_size = get_field('photo_position')['value'];
                        print_r($popup_photo_size);
                        if ($get_popup_photo_size == 'center') {
	                        $popup_photo_size = 'materialen-popup';
                        } elseif ($get_popup_photo_size == 'top') {
	                        $popup_photo_size = 'materialen-popup-top';
                        } elseif ($get_popup_photo_size == 'bottom') {
	                        $popup_photo_size = 'materialen-popup-bottom';
                        } else {
	                        $popup_photo_size = 'materialen-popup';
                        }
                    ?>

                    <div class="materiaal-id"><?php the_ID(); ?></div>

	                <div style="display: none;">
                        <?php echo get_the_post_thumbnail_url($getPhotoField->ID, 'materialen-popup'); ?>
	                    <?php echo get_the_post_thumbnail_url($getPhotoField->ID, 'materialen-popup-top'); ?>
	                    <?php echo get_the_post_thumbnail_url($getPhotoField->ID, 'materialen-popup-bottom'); ?>
                    </div>

                    <div class="img-url"><?php echo get_the_post_thumbnail_url($getPhotoField->ID, $popup_photo_size); ?></div>
                    <div class="img-url-full"><?php echo get_the_post_thumbnail_url($getPhotoField->ID, 'full'); ?></div>
                    <div class="materiaal-title"><?php the_title(); ?></div>
                    <div class="category-name"><?php echo $categorie_name; ?></div>
                    <div class="materiaal-content"><?php the_content(); ?></div>
                    <div class="materiaal-date"><?php echo $getDate; ?></div>
                    <div class="materiaal-share-slug"><?php echo home_url() . '/materialen/?mc_slug=' . basename(get_permalink()); ?></div>
                </div>
            </div>

		<?php endwhile;
		wp_reset_postdata();
	else:
		// echo '<h3 class="materiaal-no-results">Geen resultaten gevonden</h3>';
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
			'meta_key' => 'date',
			'orderby' => 'meta_value',
			'order'   => 'DESC',
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

                $get_container_landing_page_status = get_field('open_container_landing_page');
                $get_container_landing_page_id = get_field('select_container_landing_page');

            ?>

            <!-- Single Item -->
            <div class="item__single <?php if ($get_container_landing_page_status) echo 'disablePopup'; ?>" id="materiaal-<?php echo get_the_ID(); ?>">
                <figure class="item__single-img template-item hover-item">
	                <?php $getPhotoField = get_field('photo'); ?>
	                <?php if ($get_container_landing_page_status) : ?>
                        <a href="<?php echo get_the_permalink($get_container_landing_page_id); ?>">
                            <img src="<?php echo get_the_post_thumbnail_url($getPhotoField->ID, 'materialen-card'); ?>" alt="<?php the_title();?>">
                        </a>
	                <?php else : ?>
                        <img src="<?php echo get_the_post_thumbnail_url($getPhotoField->ID, 'materialen-card'); ?>" alt="<?php the_title();?>">
	                <?php endif; ?>
                    <div class="cat-label" style="background-color: <?php echo $categorie_color; ?> !important;"><?php echo $categorie_name; ?></div>
                </figure>

	            <?php if ($get_container_landing_page_status) : ?>
                    <a href="<?php echo get_the_permalink($get_container_landing_page_id); ?>">
                        <h4 class="item__single-title"><?php the_title();?> </h4>
                    </a>
	            <?php else : ?>
                    <h4 class="item__single-title"><?php the_title();?> </h4>
	            <?php endif; ?>

                <div class="item__single-desc">
		            <?php if ($get_container_landing_page_status) : ?>
                        <a href="<?php echo get_the_permalink($get_container_landing_page_id); ?>">
				            <?php the_excerpt(); ?>
                        </a>
		            <?php else : ?>
			            <?php the_excerpt(); ?>
		            <?php endif; ?>
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
						                <?php
						                $getFileIconType = $getAttachement['file_icon'];
						                $getFileIconURL = '';
						                if ($getFileIconType == 'xls') {
							                $getFileIconURL = plugin_dir_url(__FILE__) . '../images/excel.svg';
						                } elseif ($getFileIconType == 'ppt') {
							                $getFileIconURL = plugin_dir_url(__FILE__) . '../images/ppt.svg';
						                } elseif ($getFileIconType == 'doc') {
							                $getFileIconURL = plugin_dir_url(__FILE__) . '../images/word.svg';
						                } elseif ($getFileIconType == 'pdf') {
							                $getFileIconURL = plugin_dir_url(__FILE__) . '../images/pdf.svg';
						                } elseif ($getFileIconType == 'link') {
							                $getFileIconURL = plugin_dir_url(__FILE__) . '../images/glob.svg';
						                } elseif ($getFileIconType == 'folder') {
							                $getFileIconURL = plugin_dir_url(__FILE__) . '../images/folder.svg';
						                }
						                ?>
                                        <img src="<?php echo $getFileIconURL; ?>" alt="Download">
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
                                <p class="info-title">Fotograaf: <?php echo get_field('maker', $getPhotoField->ID); ?></p>
                                <div class="license-info">
                                    Rechten:
                                    <div class="licenses-list-wrapper">
						                <?php $getAllRechten = get_field('rechten', $getPhotoField->ID); ?>
                                        <ul>
							                <?php foreach ($getAllRechten as $getSingleRechten) { ?>
                                                <li>
									                <?php $getRechtenValue = $getSingleRechten['value']; ?>

									                <?php if ($getRechtenValue == 'zero') { ?>

                                                        <a href="https://creativecommons.org/publicdomain/zero/1.0/deed.nl" target="_blank">
                                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                 width="64px" height="64px" viewBox="-0.5 0.5 64 64" enable-background="new -0.5 0.5 64 64" xml:space="preserve">
                                                            <g>
                                                                <circle fill="transparent" cx="31.325" cy="32.873" r="30.096"/>
                                                                <path id="text2809_1_" d="M31.5,14.08c-10.565,0-13.222,9.969-13.222,18.42c0,8.452,2.656,18.42,13.222,18.42
                                                                    c10.564,0,13.221-9.968,13.221-18.42C44.721,24.049,42.064,14.08,31.5,14.08z M31.5,21.026c0.429,0,0.82,0.066,1.188,0.157
                                                                    c0.761,0.656,1.133,1.561,0.403,2.823l-7.036,12.93c-0.216-1.636-0.247-3.24-0.247-4.437C25.808,28.777,26.066,21.026,31.5,21.026z
                                                                     M36.766,26.987c0.373,1.984,0.426,4.056,0.426,5.513c0,3.723-0.258,11.475-5.69,11.475c-0.428,0-0.822-0.045-1.188-0.136
                                                                    c-0.07-0.021-0.134-0.043-0.202-0.067c-0.112-0.032-0.23-0.068-0.336-0.11c-1.21-0.515-1.972-1.446-0.874-3.093L36.766,26.987z"/>
                                                                <path id="path2815_1_" d="M31.433,0.5c-8.877,0-16.359,3.09-22.454,9.3c-3.087,3.087-5.443,6.607-7.082,10.532
                                                                    C0.297,24.219-0.5,28.271-0.5,32.5c0,4.268,0.797,8.32,2.397,12.168c1.6,3.85,3.921,7.312,6.969,10.396
                                                                    c3.085,3.049,6.549,5.399,10.398,7.037c3.886,1.602,7.939,2.398,12.169,2.398c4.229,0,8.34-0.826,12.303-2.465
                                                                    c3.962-1.639,7.496-3.994,10.621-7.081c3.011-2.933,5.289-6.297,6.812-10.106C62.73,41,63.5,36.883,63.5,32.5
                                                                    c0-4.343-0.77-8.454-2.33-12.303c-1.562-3.885-3.848-7.32-6.857-10.33C48.025,3.619,40.385,0.5,31.433,0.5z M31.567,6.259
                                                                    c7.238,0,13.412,2.566,18.554,7.709c2.477,2.477,4.375,5.31,5.67,8.471c1.296,3.162,1.949,6.518,1.949,10.061
                                                                    c0,7.354-2.516,13.454-7.506,18.33c-2.592,2.516-5.502,4.447-8.74,5.781c-3.2,1.334-6.498,1.994-9.927,1.994
                                                                    c-3.468,0-6.788-0.653-9.949-1.948c-3.163-1.334-6.001-3.238-8.516-5.716c-2.515-2.514-4.455-5.353-5.826-8.516
                                                                    c-1.333-3.199-2.017-6.498-2.017-9.927c0-3.467,0.684-6.787,2.017-9.949c1.371-3.2,3.312-6.074,5.826-8.628
                                                                    C18.092,8.818,24.252,6.259,31.567,6.259z"/>
                                                            </g>
                                                        </svg>
                                                        </a>

									                <?php } elseif ($getRechtenValue == 'by-attribution') { ?>
                                                        <a href="https://creativecommons.org/licenses/by/4.0/deed.nl" target="_blank">
                                                            <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                 width="64px" height="64px" viewBox="5.5 -3.5 64 64" enable-background="new 5.5 -3.5 64 64" xml:space="preserve">
                                                            <g>
                                                                <circle fill="transparent" cx="37.637" cy="28.806" r="28.276"/>
                                                                <g>
                                                                    <path d="M37.443-3.5c8.988,0,16.57,3.085,22.742,9.257C66.393,11.967,69.5,19.548,69.5,28.5c0,8.991-3.049,16.476-9.145,22.456
                                                                        C53.879,57.319,46.242,60.5,37.443,60.5c-8.649,0-16.153-3.144-22.514-9.43C8.644,44.784,5.5,37.262,5.5,28.5
                                                                        c0-8.761,3.144-16.342,9.429-22.742C21.101-0.415,28.604-3.5,37.443-3.5z M37.557,2.272c-7.276,0-13.428,2.553-18.457,7.657
                                                                        c-5.22,5.334-7.829,11.525-7.829,18.572c0,7.086,2.59,13.22,7.77,18.398c5.181,5.182,11.352,7.771,18.514,7.771
                                                                        c7.123,0,13.334-2.607,18.629-7.828c5.029-4.838,7.543-10.952,7.543-18.343c0-7.276-2.553-13.465-7.656-18.571
                                                                        C50.967,4.824,44.795,2.272,37.557,2.272z M46.129,20.557v13.085h-3.656v15.542h-9.944V33.643h-3.656V20.557
                                                                        c0-0.572,0.2-1.057,0.599-1.457c0.401-0.399,0.887-0.6,1.457-0.6h13.144c0.533,0,1.01,0.2,1.428,0.6
                                                                        C45.918,19.5,46.129,19.986,46.129,20.557z M33.042,12.329c0-3.008,1.485-4.514,4.458-4.514s4.457,1.504,4.457,4.514
                                                                        c0,2.971-1.486,4.457-4.457,4.457S33.042,15.3,33.042,12.329z"/>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                        </a>
									                <?php } elseif ($getRechtenValue == 'by-attribution-No-derivative') {?>
                                                        <a href="https://creativecommons.org/licenses/by-nd/4.0/deed.nl" target="_blank">
                                                            <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                 width="64px" height="64px" viewBox="5.5 -3.5 64 64" enable-background="new 5.5 -3.5 64 64" xml:space="preserve">
                                                            <g>
                                                                <circle fill="transparent" cx="37.637" cy="28.806" r="28.276"/>
                                                                <g>
                                                                    <path d="M37.443-3.5c8.988,0,16.57,3.085,22.742,9.257C66.393,11.967,69.5,19.548,69.5,28.5c0,8.991-3.049,16.476-9.145,22.456
                                                                        C53.879,57.319,46.242,60.5,37.443,60.5c-8.649,0-16.153-3.144-22.514-9.43C8.644,44.784,5.5,37.262,5.5,28.5
                                                                        c0-8.761,3.144-16.342,9.429-22.742C21.101-0.415,28.604-3.5,37.443-3.5z M37.557,2.272c-7.276,0-13.428,2.553-18.457,7.657
                                                                        c-5.22,5.334-7.829,11.525-7.829,18.572c0,7.086,2.59,13.22,7.77,18.398c5.181,5.182,11.352,7.771,18.514,7.771
                                                                        c7.123,0,13.334-2.607,18.629-7.828c5.029-4.838,7.543-10.952,7.543-18.343c0-7.276-2.553-13.465-7.656-18.571
                                                                        C50.967,4.824,44.795,2.272,37.557,2.272z M46.129,20.557v13.085h-3.656v15.542h-9.944V33.643h-3.656V20.557
                                                                        c0-0.572,0.2-1.057,0.599-1.457c0.401-0.399,0.887-0.6,1.457-0.6h13.144c0.533,0,1.01,0.2,1.428,0.6
                                                                        C45.918,19.5,46.129,19.986,46.129,20.557z M33.042,12.329c0-3.008,1.485-4.514,4.458-4.514s4.457,1.504,4.457,4.514
                                                                        c0,2.971-1.486,4.457-4.457,4.457S33.042,15.3,33.042,12.329z"/>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                 width="64.000977px" height="64px" viewBox="0 0 64.000977 64" enable-background="new 0 0 64.000977 64" xml:space="preserve">
                                                            <g>
                                                                <circle fill="transparent" cx="32.064453" cy="31.788086" r="29.012695"/>
                                                                <g>
                                                                    <path d="M31.943848,0C40.896484,0,48.476562,3.105469,54.6875,9.314453C60.894531,15.486328,64.000977,23.045898,64.000977,32
                                                                        s-3.048828,16.457031-9.145508,22.513672C48.417969,60.837891,40.779297,64,31.942871,64
                                                                        c-8.648926,0-16.152832-3.142578-22.513672-9.429688C3.144043,48.286133,0,40.761719,0,32.000977
                                                                        c0-8.723633,3.144043-16.285156,9.429199-22.68457C15.640137,3.105469,23.14502,0,31.943848,0z M32.060547,5.771484
                                                                        c-7.275391,0-13.429688,2.570312-18.458496,7.714844C8.381836,18.783203,5.772949,24.954102,5.772949,32
                                                                        c0,7.125,2.589844,13.256836,7.77002,18.400391c5.181152,5.181641,11.352051,7.770508,18.515625,7.770508
                                                                        c7.123047,0,13.332031-2.608398,18.626953-7.828125C55.713867,45.466797,58.228516,39.353516,58.228516,32
                                                                        c0-7.3125-2.553711-13.484375-7.65625-18.513672C45.504883,8.341797,39.333984,5.771484,32.060547,5.771484z M44.117188,24.456055
                                                                        v5.485352H20.859863v-5.485352H44.117188z M44.117188,34.743164v5.481445H20.859863v-5.481445H44.117188z"/>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                        </a>
									                <?php } elseif ($getRechtenValue == 'by-attribution-Share-alike') {?>
                                                        <a href="https://creativecommons.org/licenses/by-sa/4.0/deed.nl" target="_blank">
                                                            <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                 width="64px" height="64px" viewBox="5.5 -3.5 64 64" enable-background="new 5.5 -3.5 64 64" xml:space="preserve">
                                                            <g>
                                                                <circle fill="transparent" cx="37.637" cy="28.806" r="28.276"/>
                                                                <g>
                                                                    <path d="M37.443-3.5c8.988,0,16.57,3.085,22.742,9.257C66.393,11.967,69.5,19.548,69.5,28.5c0,8.991-3.049,16.476-9.145,22.456
                                                                        C53.879,57.319,46.242,60.5,37.443,60.5c-8.649,0-16.153-3.144-22.514-9.43C8.644,44.784,5.5,37.262,5.5,28.5
                                                                        c0-8.761,3.144-16.342,9.429-22.742C21.101-0.415,28.604-3.5,37.443-3.5z M37.557,2.272c-7.276,0-13.428,2.553-18.457,7.657
                                                                        c-5.22,5.334-7.829,11.525-7.829,18.572c0,7.086,2.59,13.22,7.77,18.398c5.181,5.182,11.352,7.771,18.514,7.771
                                                                        c7.123,0,13.334-2.607,18.629-7.828c5.029-4.838,7.543-10.952,7.543-18.343c0-7.276-2.553-13.465-7.656-18.571
                                                                        C50.967,4.824,44.795,2.272,37.557,2.272z M46.129,20.557v13.085h-3.656v15.542h-9.944V33.643h-3.656V20.557
                                                                        c0-0.572,0.2-1.057,0.599-1.457c0.401-0.399,0.887-0.6,1.457-0.6h13.144c0.533,0,1.01,0.2,1.428,0.6
                                                                        C45.918,19.5,46.129,19.986,46.129,20.557z M33.042,12.329c0-3.008,1.485-4.514,4.458-4.514s4.457,1.504,4.457,4.514
                                                                        c0,2.971-1.486,4.457-4.457,4.457S33.042,15.3,33.042,12.329z"/>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                            <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                 width="64px" height="64px" viewBox="5.5 -3.5 64 64" enable-background="new 5.5 -3.5 64 64" xml:space="preserve">
                                                            <g>
                                                                <circle fill="transparent" cx="36.944" cy="28.631" r="29.105"/>
                                                                <g>
                                                                    <path d="M37.443-3.5c8.951,0,16.531,3.105,22.742,9.315C66.393,11.987,69.5,19.548,69.5,28.5c0,8.954-3.049,16.457-9.145,22.514
                                                                        C53.918,57.338,46.279,60.5,37.443,60.5c-8.649,0-16.153-3.143-22.514-9.429C8.644,44.786,5.5,37.264,5.5,28.501
                                                                        c0-8.723,3.144-16.285,9.429-22.685C21.138-0.395,28.643-3.5,37.443-3.5z M37.557,2.272c-7.276,0-13.428,2.572-18.457,7.715
                                                                        c-5.22,5.296-7.829,11.467-7.829,18.513c0,7.125,2.59,13.257,7.77,18.4c5.181,5.182,11.352,7.771,18.514,7.771
                                                                        c7.123,0,13.334-2.609,18.629-7.828c5.029-4.876,7.543-10.99,7.543-18.343c0-7.313-2.553-13.485-7.656-18.513
                                                                        C51.004,4.842,44.832,2.272,37.557,2.272z M23.271,23.985c0.609-3.924,2.189-6.962,4.742-9.114
                                                                        c2.552-2.152,5.656-3.228,9.314-3.228c5.027,0,9.029,1.62,12,4.856c2.971,3.238,4.457,7.391,4.457,12.457
                                                                        c0,4.915-1.543,9-4.627,12.256c-3.088,3.256-7.086,4.886-12.002,4.886c-3.619,0-6.743-1.085-9.371-3.257
                                                                        c-2.629-2.172-4.209-5.257-4.743-9.257H31.1c0.19,3.886,2.533,5.829,7.029,5.829c2.246,0,4.057-0.972,5.428-2.914
                                                                        c1.373-1.942,2.059-4.534,2.059-7.771c0-3.391-0.629-5.971-1.885-7.743c-1.258-1.771-3.066-2.657-5.43-2.657
                                                                        c-4.268,0-6.667,1.885-7.2,5.656h2.343l-6.342,6.343l-6.343-6.343L23.271,23.985L23.271,23.985z"/>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                        </a>
									                <?php } elseif ($getRechtenValue == 'by-attribution-nonCommercial-ShareAlike') {?>
                                                        <a href="https://creativecommons.org/licenses/by-nc-sa/4.0/deed.nl" target="_blank">
                                                            <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                 width="64px" height="64px" viewBox="5.5 -3.5 64 64" enable-background="new 5.5 -3.5 64 64" xml:space="preserve">
                                                                <g>
                                                                    <circle fill="transparent" cx="37.785" cy="28.501" r="28.836"/>
                                                                    <path d="M37.441-3.5c8.951,0,16.572,3.125,22.857,9.372c3.008,3.009,5.295,6.448,6.857,10.314
                                                                        c1.561,3.867,2.344,7.971,2.344,12.314c0,4.381-0.773,8.486-2.314,12.313c-1.543,3.828-3.82,7.21-6.828,10.143
                                                                        c-3.123,3.085-6.666,5.448-10.629,7.086c-3.961,1.638-8.057,2.457-12.285,2.457s-8.276-0.808-12.143-2.429
                                                                        c-3.866-1.618-7.333-3.961-10.4-7.027c-3.067-3.066-5.4-6.524-7-10.372S5.5,32.767,5.5,28.5c0-4.229,0.809-8.295,2.428-12.2
                                                                        c1.619-3.905,3.972-7.4,7.057-10.486C21.08-0.394,28.565-3.5,37.441-3.5z M37.557,2.272c-7.314,0-13.467,2.553-18.458,7.657
                                                                        c-2.515,2.553-4.448,5.419-5.8,8.6c-1.354,3.181-2.029,6.505-2.029,9.972c0,3.429,0.675,6.734,2.029,9.913
                                                                        c1.353,3.183,3.285,6.021,5.8,8.516c2.514,2.496,5.351,4.399,8.515,5.715c3.161,1.314,6.476,1.971,9.943,1.971
                                                                        c3.428,0,6.75-0.665,9.973-1.999c3.219-1.335,6.121-3.257,8.713-5.771c4.99-4.876,7.484-10.99,7.484-18.344
                                                                        c0-3.543-0.648-6.895-1.943-10.057c-1.293-3.162-3.18-5.98-5.654-8.458C50.984,4.844,44.795,2.272,37.557,2.272z M37.156,23.187
                                                                        l-4.287,2.229c-0.458-0.951-1.019-1.619-1.685-2c-0.667-0.38-1.286-0.571-1.858-0.571c-2.856,0-4.286,1.885-4.286,5.657
                                                                        c0,1.714,0.362,3.084,1.085,4.113c0.724,1.029,1.791,1.544,3.201,1.544c1.867,0,3.181-0.915,3.944-2.743l3.942,2
                                                                        c-0.838,1.563-2,2.791-3.486,3.686c-1.484,0.896-3.123,1.343-4.914,1.343c-2.857,0-5.163-0.875-6.915-2.629
                                                                        c-1.752-1.752-2.628-4.19-2.628-7.313c0-3.048,0.886-5.466,2.657-7.257c1.771-1.79,4.009-2.686,6.715-2.686
                                                                        C32.604,18.558,35.441,20.101,37.156,23.187z M55.613,23.187l-4.229,2.229c-0.457-0.951-1.02-1.619-1.686-2
                                                                        c-0.668-0.38-1.307-0.571-1.914-0.571c-2.857,0-4.287,1.885-4.287,5.657c0,1.714,0.363,3.084,1.086,4.113
                                                                        c0.723,1.029,1.789,1.544,3.201,1.544c1.865,0,3.18-0.915,3.941-2.743l4,2c-0.875,1.563-2.057,2.791-3.541,3.686
                                                                        c-1.486,0.896-3.105,1.343-4.857,1.343c-2.896,0-5.209-0.875-6.941-2.629c-1.736-1.752-2.602-4.19-2.602-7.313
                                                                        c0-3.048,0.885-5.466,2.658-7.257c1.77-1.79,4.008-2.686,6.713-2.686C51.117,18.558,53.938,20.101,55.613,23.187z"/>
                                                                </g>
                                                            </svg>
                                                            <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                 width="64px" height="64px" viewBox="5.5 -3.5 64 64" enable-background="new 5.5 -3.5 64 64" xml:space="preserve">
                                                                <g>
                                                                    <circle fill="transparent" cx="37.637" cy="28.806" r="28.276"/>
                                                                    <g>
                                                                        <path d="M37.443-3.5c8.988,0,16.57,3.085,22.742,9.257C66.393,11.967,69.5,19.548,69.5,28.5c0,8.991-3.049,16.476-9.145,22.456
                                                                            C53.879,57.319,46.242,60.5,37.443,60.5c-8.649,0-16.153-3.144-22.514-9.43C8.644,44.784,5.5,37.262,5.5,28.5
                                                                            c0-8.761,3.144-16.342,9.429-22.742C21.101-0.415,28.604-3.5,37.443-3.5z M37.557,2.272c-7.276,0-13.428,2.553-18.457,7.657
                                                                            c-5.22,5.334-7.829,11.525-7.829,18.572c0,7.086,2.59,13.22,7.77,18.398c5.181,5.182,11.352,7.771,18.514,7.771
                                                                            c7.123,0,13.334-2.607,18.629-7.828c5.029-4.838,7.543-10.952,7.543-18.343c0-7.276-2.553-13.465-7.656-18.571
                                                                            C50.967,4.824,44.795,2.272,37.557,2.272z M46.129,20.557v13.085h-3.656v15.542h-9.944V33.643h-3.656V20.557
                                                                            c0-0.572,0.2-1.057,0.599-1.457c0.401-0.399,0.887-0.6,1.457-0.6h13.144c0.533,0,1.01,0.2,1.428,0.6
                                                                            C45.918,19.5,46.129,19.986,46.129,20.557z M33.042,12.329c0-3.008,1.485-4.514,4.458-4.514s4.457,1.504,4.457,4.514
                                                                            c0,2.971-1.486,4.457-4.457,4.457S33.042,15.3,33.042,12.329z"/>
                                                                    </g>
                                                                </g>
                                                            </svg>
                                                            <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                 width="64px" height="64px" viewBox="5.5 -3.5 64 64" enable-background="new 5.5 -3.5 64 64" xml:space="preserve">
                                                                <g>
                                                                    <circle fill="transparent" cx="37.47" cy="28.736" r="29.471"/>
                                                                    <g>
                                                                        <path d="M37.442-3.5c8.99,0,16.571,3.085,22.743,9.256C66.393,11.928,69.5,19.509,69.5,28.5c0,8.992-3.048,16.476-9.145,22.458
                                                                            C53.88,57.32,46.241,60.5,37.442,60.5c-8.686,0-16.19-3.162-22.513-9.485C8.644,44.728,5.5,37.225,5.5,28.5
                                                                            c0-8.762,3.144-16.343,9.429-22.743C21.1-0.414,28.604-3.5,37.442-3.5z M12.7,19.872c-0.952,2.628-1.429,5.505-1.429,8.629
                                                                            c0,7.086,2.59,13.22,7.77,18.4c5.219,5.144,11.391,7.715,18.514,7.715c7.201,0,13.409-2.608,18.63-7.829
                                                                            c1.867-1.79,3.332-3.657,4.398-5.602l-12.056-5.371c-0.421,2.02-1.439,3.667-3.057,4.942c-1.622,1.276-3.535,2.011-5.744,2.2
                                                                            v4.915h-3.714v-4.915c-3.543-0.036-6.782-1.312-9.714-3.827l4.4-4.457c2.094,1.942,4.476,2.913,7.143,2.913
                                                                            c1.104,0,2.048-0.246,2.83-0.743c0.78-0.494,1.172-1.312,1.172-2.457c0-0.801-0.287-1.448-0.858-1.943l-3.085-1.315l-3.771-1.715
                                                                            l-5.086-2.229L12.7,19.872z M37.557,2.214c-7.276,0-13.428,2.571-18.457,7.714c-1.258,1.258-2.439,2.686-3.543,4.287L27.786,19.7
                                                                            c0.533-1.676,1.542-3.019,3.029-4.028c1.484-1.009,3.218-1.571,5.2-1.686V9.071h3.715v4.915c2.934,0.153,5.6,1.143,8,2.971
                                                                            l-4.172,4.286c-1.793-1.257-3.619-1.885-5.486-1.885c-0.991,0-1.876,0.191-2.656,0.571c-0.781,0.381-1.172,1.029-1.172,1.943
                                                                            c0,0.267,0.095,0.533,0.285,0.8l4.057,1.83l2.8,1.257l5.144,2.285l16.397,7.314c0.535-2.248,0.801-4.533,0.801-6.857
                                                                            c0-7.353-2.552-13.543-7.656-18.573C51.005,4.785,44.831,2.214,37.557,2.214z"/>
                                                                    </g>
                                                                </g>
                                                            </svg>
                                                            <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                 width="64px" height="64px" viewBox="5.5 -3.5 64 64" enable-background="new 5.5 -3.5 64 64" xml:space="preserve">
                                                                <g>
                                                                    <circle fill="transparent" cx="36.944" cy="28.631" r="29.105"/>
                                                                    <g>
                                                                        <path d="M37.443-3.5c8.951,0,16.531,3.105,22.742,9.315C66.393,11.987,69.5,19.548,69.5,28.5c0,8.954-3.049,16.457-9.145,22.514
                                                                            C53.918,57.338,46.279,60.5,37.443,60.5c-8.649,0-16.153-3.143-22.514-9.429C8.644,44.786,5.5,37.264,5.5,28.501
                                                                            c0-8.723,3.144-16.285,9.429-22.685C21.138-0.395,28.643-3.5,37.443-3.5z M37.557,2.272c-7.276,0-13.428,2.572-18.457,7.715
                                                                            c-5.22,5.296-7.829,11.467-7.829,18.513c0,7.125,2.59,13.257,7.77,18.4c5.181,5.182,11.352,7.771,18.514,7.771
                                                                            c7.123,0,13.334-2.609,18.629-7.828c5.029-4.876,7.543-10.99,7.543-18.343c0-7.313-2.553-13.485-7.656-18.513
                                                                            C51.004,4.842,44.832,2.272,37.557,2.272z M23.271,23.985c0.609-3.924,2.189-6.962,4.742-9.114
                                                                            c2.552-2.152,5.656-3.228,9.314-3.228c5.027,0,9.029,1.62,12,4.856c2.971,3.238,4.457,7.391,4.457,12.457
                                                                            c0,4.915-1.543,9-4.627,12.256c-3.088,3.256-7.086,4.886-12.002,4.886c-3.619,0-6.743-1.085-9.371-3.257
                                                                            c-2.629-2.172-4.209-5.257-4.743-9.257H31.1c0.19,3.886,2.533,5.829,7.029,5.829c2.246,0,4.057-0.972,5.428-2.914
                                                                            c1.373-1.942,2.059-4.534,2.059-7.771c0-3.391-0.629-5.971-1.885-7.743c-1.258-1.771-3.066-2.657-5.43-2.657
                                                                            c-4.268,0-6.667,1.885-7.2,5.656h2.343l-6.342,6.343l-6.343-6.343L23.271,23.985L23.271,23.985z"/>
                                                                    </g>
                                                                </g>
                                                            </svg>
                                                        </a>
									                <?php } ?>

                                                </li>
							                <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="content-btn">
                                <a href="<?php echo get_the_post_thumbnail_url($getPhotoField->ID, 'full'); ?>" class="info-btn full-img-download-btn" download>Download</a>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="materialen-hidden-fields" style="display: none;">
	                <?php
                        $popup_photo_size = '';
                        $get_popup_photo_size = get_field('photo_position')['value'];
                        print_r($popup_photo_size);
                        if ($get_popup_photo_size == 'center') {
                            $popup_photo_size = 'materialen-popup';
                        } elseif ($get_popup_photo_size == 'top') {
                            $popup_photo_size = 'materialen-popup-top';
                        } elseif ($get_popup_photo_size == 'bottom') {
                            $popup_photo_size = 'materialen-popup-bottom';
                        } else {
                            $popup_photo_size = 'materialen-popup';
                        }
	                ?>

                    <div class="materiaal-id"><?php the_ID(); ?></div>

                    <div style="display: none;">
		                <?php echo get_the_post_thumbnail_url($getPhotoField->ID, 'materialen-popup'); ?>
		                <?php echo get_the_post_thumbnail_url($getPhotoField->ID, 'materialen-popup-top'); ?>
		                <?php echo get_the_post_thumbnail_url($getPhotoField->ID, 'materialen-popup-bottom'); ?>
                    </div>

                    <div class="img-url"><?php echo get_the_post_thumbnail_url($getPhotoField->ID, $popup_photo_size); ?></div>
                    <div class="img-url-full"><?php echo get_the_post_thumbnail_url($getPhotoField->ID, 'full'); ?></div>
                    <div class="materiaal-title"><?php the_title(); ?></div>
                    <div class="category-name"><?php echo $categorie_name; ?></div>
                    <div class="materiaal-content"><?php the_content(); ?></div>
                    <div class="materiaal-date"><?php echo $getDate; ?></div>
                    <div class="materiaal-share-slug"><?php echo home_url() . '/materialen/?mc_slug=' . basename(get_permalink()); ?></div>
                </div>
            </div>

		<?php endwhile;
		wp_reset_postdata();
	else:
		echo '<h3 class="materiaal-no-results">Geen resultaten gevonden</h3>';
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



    if( $the_query->have_posts() ) :
        echo '<div class="material__items search__items">';
		while( $the_query->have_posts() ): $the_query->the_post(); ?>

			<?php

			$categorie_terms = wp_get_post_terms(get_the_ID(), 'categorie', array( 'fields' => 'all' ));
			$first_categorie = array_values($categorie_terms)[0];
			$categorie_name = $first_categorie->name;

			?>

            <!-- Single Item -->
            <div class="item__single">
                <figure class="item__single-img">
	                <?php $getPhotoField = get_field('photo'); ?>
                    <img src="<?php echo get_the_post_thumbnail_url($getPhotoField->ID, 'materialen-hero'); ?>" alt="<?php the_title(); ?>">
                </figure>
                <h4 class="item__single-title">
                    <a href="#!"><?php the_title(); ?></a>
                </h4>
                <div class="item__single-desc">
                    <?php the_excerpt(); ?>
                </div>

                <div class="materialen-hidden-fields" style="display: none;">
	                <?php
                        $popup_photo_size = '';
                        $get_popup_photo_size = get_field('photo_position')['value'];
                        print_r($popup_photo_size);
                        if ($get_popup_photo_size == 'center') {
                            $popup_photo_size = 'materialen-popup';
                        } elseif ($get_popup_photo_size == 'top') {
                            $popup_photo_size = 'materialen-popup-top';
                        } elseif ($get_popup_photo_size == 'bottom') {
                            $popup_photo_size = 'materialen-popup-bottom';
                        } else {
                            $popup_photo_size = 'materialen-popup';
                        }
	                ?>

                    <div class="materiaal-id"><?php the_ID(); ?></div>

                    <div style="display: none;">
		                <?php echo get_the_post_thumbnail_url($getPhotoField->ID, 'materialen-popup'); ?>
		                <?php echo get_the_post_thumbnail_url($getPhotoField->ID, 'materialen-popup-top'); ?>
		                <?php echo get_the_post_thumbnail_url($getPhotoField->ID, 'materialen-popup-bottom'); ?>
                    </div>

                    <div class="img-url"><?php echo get_the_post_thumbnail_url($getPhotoField->ID, $popup_photo_size); ?></div>
                    <div class="img-url-full"><?php echo get_the_post_thumbnail_url($getPhotoField->ID, 'full'); ?></div>
                    <div class="materiaal-title"><?php the_title(); ?></div>
                    <div class="category-name"><?php echo $categorie_name; ?></div>
                    <div class="materiaal-content"><?php the_content(); ?></div>
                    <div class="materiaal-date"><?php echo get_field('date'); ?></div>
                    <div class="materiaal-share-slug"><?php echo home_url() . '/materialen/?mc_slug=' . basename(get_permalink()); ?></div>
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
	                                <?php
                                        $getFileIconType = $getAttachement['file_icon'];
                                        $getFileIconURL = '';
                                        if ($getFileIconType == 'xls') {
	                                        $getFileIconURL = plugin_dir_url(__FILE__) . '../images/excel.svg';
                                        } elseif ($getFileIconType == 'ppt') {
	                                        $getFileIconURL = plugin_dir_url(__FILE__) . '../images/ppt.svg';
                                        } elseif ($getFileIconType == 'doc') {
	                                        $getFileIconURL = plugin_dir_url(__FILE__) . '../images/word.svg';
                                        } elseif ($getFileIconType == 'pdf') {
	                                        $getFileIconURL = plugin_dir_url(__FILE__) . '../images/pdf.svg';
                                        } elseif ($getFileIconType == 'link') {
	                                        $getFileIconURL = plugin_dir_url(__FILE__) . '../images/glob.svg';
                                        } elseif ($getFileIconType == 'folder') {
	                                        $getFileIconURL = plugin_dir_url(__FILE__) . '../images/folder.svg';
                                        }
                                    ?>
                                    <img src="<?php echo $getFileIconURL; ?>" alt="Download">
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
                            <p class="info-title">Fotograaf: <?php echo get_field('maker', $getPhotoField->ID); ?></p>
                            <div class="license-info">
                                Rechten:
                                <div class="licenses-list-wrapper">
						            <?php $getAllRechten = get_field('rechten', $getPhotoField->ID); ?>
                                    <ul>
							            <?php foreach ($getAllRechten as $getSingleRechten) { ?>
                                            <li>
                                                <?php $getRechtenValue = $getSingleRechten['value']; ?>

                                                <?php if ($getRechtenValue == 'zero') { ?>

                                                    <a href="https://creativecommons.org/publicdomain/zero/1.0/deed.nl" target="_blank">
                                                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                             width="64px" height="64px" viewBox="-0.5 0.5 64 64" enable-background="new -0.5 0.5 64 64" xml:space="preserve">
                                                            <g>
                                                                <circle fill="transparent" cx="31.325" cy="32.873" r="30.096"/>
                                                                <path id="text2809_1_" d="M31.5,14.08c-10.565,0-13.222,9.969-13.222,18.42c0,8.452,2.656,18.42,13.222,18.42
                                                                    c10.564,0,13.221-9.968,13.221-18.42C44.721,24.049,42.064,14.08,31.5,14.08z M31.5,21.026c0.429,0,0.82,0.066,1.188,0.157
                                                                    c0.761,0.656,1.133,1.561,0.403,2.823l-7.036,12.93c-0.216-1.636-0.247-3.24-0.247-4.437C25.808,28.777,26.066,21.026,31.5,21.026z
                                                                     M36.766,26.987c0.373,1.984,0.426,4.056,0.426,5.513c0,3.723-0.258,11.475-5.69,11.475c-0.428,0-0.822-0.045-1.188-0.136
                                                                    c-0.07-0.021-0.134-0.043-0.202-0.067c-0.112-0.032-0.23-0.068-0.336-0.11c-1.21-0.515-1.972-1.446-0.874-3.093L36.766,26.987z"/>
                                                                <path id="path2815_1_" d="M31.433,0.5c-8.877,0-16.359,3.09-22.454,9.3c-3.087,3.087-5.443,6.607-7.082,10.532
                                                                    C0.297,24.219-0.5,28.271-0.5,32.5c0,4.268,0.797,8.32,2.397,12.168c1.6,3.85,3.921,7.312,6.969,10.396
                                                                    c3.085,3.049,6.549,5.399,10.398,7.037c3.886,1.602,7.939,2.398,12.169,2.398c4.229,0,8.34-0.826,12.303-2.465
                                                                    c3.962-1.639,7.496-3.994,10.621-7.081c3.011-2.933,5.289-6.297,6.812-10.106C62.73,41,63.5,36.883,63.5,32.5
                                                                    c0-4.343-0.77-8.454-2.33-12.303c-1.562-3.885-3.848-7.32-6.857-10.33C48.025,3.619,40.385,0.5,31.433,0.5z M31.567,6.259
                                                                    c7.238,0,13.412,2.566,18.554,7.709c2.477,2.477,4.375,5.31,5.67,8.471c1.296,3.162,1.949,6.518,1.949,10.061
                                                                    c0,7.354-2.516,13.454-7.506,18.33c-2.592,2.516-5.502,4.447-8.74,5.781c-3.2,1.334-6.498,1.994-9.927,1.994
                                                                    c-3.468,0-6.788-0.653-9.949-1.948c-3.163-1.334-6.001-3.238-8.516-5.716c-2.515-2.514-4.455-5.353-5.826-8.516
                                                                    c-1.333-3.199-2.017-6.498-2.017-9.927c0-3.467,0.684-6.787,2.017-9.949c1.371-3.2,3.312-6.074,5.826-8.628
                                                                    C18.092,8.818,24.252,6.259,31.567,6.259z"/>
                                                            </g>
                                                        </svg>
                                                    </a>

                                                <?php } elseif ($getRechtenValue == 'by-attribution') { ?>
                                                    <a href="https://creativecommons.org/licenses/by/4.0/deed.nl" target="_blank">
                                                        <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                             width="64px" height="64px" viewBox="5.5 -3.5 64 64" enable-background="new 5.5 -3.5 64 64" xml:space="preserve">
                                                            <g>
                                                                <circle fill="transparent" cx="37.637" cy="28.806" r="28.276"/>
                                                                <g>
                                                                    <path d="M37.443-3.5c8.988,0,16.57,3.085,22.742,9.257C66.393,11.967,69.5,19.548,69.5,28.5c0,8.991-3.049,16.476-9.145,22.456
                                                                        C53.879,57.319,46.242,60.5,37.443,60.5c-8.649,0-16.153-3.144-22.514-9.43C8.644,44.784,5.5,37.262,5.5,28.5
                                                                        c0-8.761,3.144-16.342,9.429-22.742C21.101-0.415,28.604-3.5,37.443-3.5z M37.557,2.272c-7.276,0-13.428,2.553-18.457,7.657
                                                                        c-5.22,5.334-7.829,11.525-7.829,18.572c0,7.086,2.59,13.22,7.77,18.398c5.181,5.182,11.352,7.771,18.514,7.771
                                                                        c7.123,0,13.334-2.607,18.629-7.828c5.029-4.838,7.543-10.952,7.543-18.343c0-7.276-2.553-13.465-7.656-18.571
                                                                        C50.967,4.824,44.795,2.272,37.557,2.272z M46.129,20.557v13.085h-3.656v15.542h-9.944V33.643h-3.656V20.557
                                                                        c0-0.572,0.2-1.057,0.599-1.457c0.401-0.399,0.887-0.6,1.457-0.6h13.144c0.533,0,1.01,0.2,1.428,0.6
                                                                        C45.918,19.5,46.129,19.986,46.129,20.557z M33.042,12.329c0-3.008,1.485-4.514,4.458-4.514s4.457,1.504,4.457,4.514
                                                                        c0,2.971-1.486,4.457-4.457,4.457S33.042,15.3,33.042,12.329z"/>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                    </a>
                                                <?php } elseif ($getRechtenValue == 'by-attribution-No-derivative') {?>
                                                    <a href="https://creativecommons.org/licenses/by-nd/4.0/deed.nl" target="_blank">
                                                        <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                             width="64px" height="64px" viewBox="5.5 -3.5 64 64" enable-background="new 5.5 -3.5 64 64" xml:space="preserve">
                                                            <g>
                                                                <circle fill="transparent" cx="37.637" cy="28.806" r="28.276"/>
                                                                <g>
                                                                    <path d="M37.443-3.5c8.988,0,16.57,3.085,22.742,9.257C66.393,11.967,69.5,19.548,69.5,28.5c0,8.991-3.049,16.476-9.145,22.456
                                                                        C53.879,57.319,46.242,60.5,37.443,60.5c-8.649,0-16.153-3.144-22.514-9.43C8.644,44.784,5.5,37.262,5.5,28.5
                                                                        c0-8.761,3.144-16.342,9.429-22.742C21.101-0.415,28.604-3.5,37.443-3.5z M37.557,2.272c-7.276,0-13.428,2.553-18.457,7.657
                                                                        c-5.22,5.334-7.829,11.525-7.829,18.572c0,7.086,2.59,13.22,7.77,18.398c5.181,5.182,11.352,7.771,18.514,7.771
                                                                        c7.123,0,13.334-2.607,18.629-7.828c5.029-4.838,7.543-10.952,7.543-18.343c0-7.276-2.553-13.465-7.656-18.571
                                                                        C50.967,4.824,44.795,2.272,37.557,2.272z M46.129,20.557v13.085h-3.656v15.542h-9.944V33.643h-3.656V20.557
                                                                        c0-0.572,0.2-1.057,0.599-1.457c0.401-0.399,0.887-0.6,1.457-0.6h13.144c0.533,0,1.01,0.2,1.428,0.6
                                                                        C45.918,19.5,46.129,19.986,46.129,20.557z M33.042,12.329c0-3.008,1.485-4.514,4.458-4.514s4.457,1.504,4.457,4.514
                                                                        c0,2.971-1.486,4.457-4.457,4.457S33.042,15.3,33.042,12.329z"/>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                        <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                 width="64.000977px" height="64px" viewBox="0 0 64.000977 64" enable-background="new 0 0 64.000977 64" xml:space="preserve">
                                                            <g>
                                                                <circle fill="transparent" cx="32.064453" cy="31.788086" r="29.012695"/>
                                                                <g>
                                                                    <path d="M31.943848,0C40.896484,0,48.476562,3.105469,54.6875,9.314453C60.894531,15.486328,64.000977,23.045898,64.000977,32
                                                                        s-3.048828,16.457031-9.145508,22.513672C48.417969,60.837891,40.779297,64,31.942871,64
                                                                        c-8.648926,0-16.152832-3.142578-22.513672-9.429688C3.144043,48.286133,0,40.761719,0,32.000977
                                                                        c0-8.723633,3.144043-16.285156,9.429199-22.68457C15.640137,3.105469,23.14502,0,31.943848,0z M32.060547,5.771484
                                                                        c-7.275391,0-13.429688,2.570312-18.458496,7.714844C8.381836,18.783203,5.772949,24.954102,5.772949,32
                                                                        c0,7.125,2.589844,13.256836,7.77002,18.400391c5.181152,5.181641,11.352051,7.770508,18.515625,7.770508
                                                                        c7.123047,0,13.332031-2.608398,18.626953-7.828125C55.713867,45.466797,58.228516,39.353516,58.228516,32
                                                                        c0-7.3125-2.553711-13.484375-7.65625-18.513672C45.504883,8.341797,39.333984,5.771484,32.060547,5.771484z M44.117188,24.456055
                                                                        v5.485352H20.859863v-5.485352H44.117188z M44.117188,34.743164v5.481445H20.859863v-5.481445H44.117188z"/>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                    </a>
                                                <?php } elseif ($getRechtenValue == 'by-attribution-Share-alike') {?>
                                                    <a href="https://creativecommons.org/licenses/by-sa/4.0/deed.nl" target="_blank">
                                                        <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                             width="64px" height="64px" viewBox="5.5 -3.5 64 64" enable-background="new 5.5 -3.5 64 64" xml:space="preserve">
                                                            <g>
                                                                <circle fill="transparent" cx="37.637" cy="28.806" r="28.276"/>
                                                                <g>
                                                                    <path d="M37.443-3.5c8.988,0,16.57,3.085,22.742,9.257C66.393,11.967,69.5,19.548,69.5,28.5c0,8.991-3.049,16.476-9.145,22.456
                                                                        C53.879,57.319,46.242,60.5,37.443,60.5c-8.649,0-16.153-3.144-22.514-9.43C8.644,44.784,5.5,37.262,5.5,28.5
                                                                        c0-8.761,3.144-16.342,9.429-22.742C21.101-0.415,28.604-3.5,37.443-3.5z M37.557,2.272c-7.276,0-13.428,2.553-18.457,7.657
                                                                        c-5.22,5.334-7.829,11.525-7.829,18.572c0,7.086,2.59,13.22,7.77,18.398c5.181,5.182,11.352,7.771,18.514,7.771
                                                                        c7.123,0,13.334-2.607,18.629-7.828c5.029-4.838,7.543-10.952,7.543-18.343c0-7.276-2.553-13.465-7.656-18.571
                                                                        C50.967,4.824,44.795,2.272,37.557,2.272z M46.129,20.557v13.085h-3.656v15.542h-9.944V33.643h-3.656V20.557
                                                                        c0-0.572,0.2-1.057,0.599-1.457c0.401-0.399,0.887-0.6,1.457-0.6h13.144c0.533,0,1.01,0.2,1.428,0.6
                                                                        C45.918,19.5,46.129,19.986,46.129,20.557z M33.042,12.329c0-3.008,1.485-4.514,4.458-4.514s4.457,1.504,4.457,4.514
                                                                        c0,2.971-1.486,4.457-4.457,4.457S33.042,15.3,33.042,12.329z"/>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                        <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                                 width="64px" height="64px" viewBox="5.5 -3.5 64 64" enable-background="new 5.5 -3.5 64 64" xml:space="preserve">
                                                            <g>
                                                                <circle fill="transparent" cx="36.944" cy="28.631" r="29.105"/>
                                                                <g>
                                                                    <path d="M37.443-3.5c8.951,0,16.531,3.105,22.742,9.315C66.393,11.987,69.5,19.548,69.5,28.5c0,8.954-3.049,16.457-9.145,22.514
                                                                        C53.918,57.338,46.279,60.5,37.443,60.5c-8.649,0-16.153-3.143-22.514-9.429C8.644,44.786,5.5,37.264,5.5,28.501
                                                                        c0-8.723,3.144-16.285,9.429-22.685C21.138-0.395,28.643-3.5,37.443-3.5z M37.557,2.272c-7.276,0-13.428,2.572-18.457,7.715
                                                                        c-5.22,5.296-7.829,11.467-7.829,18.513c0,7.125,2.59,13.257,7.77,18.4c5.181,5.182,11.352,7.771,18.514,7.771
                                                                        c7.123,0,13.334-2.609,18.629-7.828c5.029-4.876,7.543-10.99,7.543-18.343c0-7.313-2.553-13.485-7.656-18.513
                                                                        C51.004,4.842,44.832,2.272,37.557,2.272z M23.271,23.985c0.609-3.924,2.189-6.962,4.742-9.114
                                                                        c2.552-2.152,5.656-3.228,9.314-3.228c5.027,0,9.029,1.62,12,4.856c2.971,3.238,4.457,7.391,4.457,12.457
                                                                        c0,4.915-1.543,9-4.627,12.256c-3.088,3.256-7.086,4.886-12.002,4.886c-3.619,0-6.743-1.085-9.371-3.257
                                                                        c-2.629-2.172-4.209-5.257-4.743-9.257H31.1c0.19,3.886,2.533,5.829,7.029,5.829c2.246,0,4.057-0.972,5.428-2.914
                                                                        c1.373-1.942,2.059-4.534,2.059-7.771c0-3.391-0.629-5.971-1.885-7.743c-1.258-1.771-3.066-2.657-5.43-2.657
                                                                        c-4.268,0-6.667,1.885-7.2,5.656h2.343l-6.342,6.343l-6.343-6.343L23.271,23.985L23.271,23.985z"/>
                                                                </g>
                                                            </g>
                                                        </svg>
                                                    </a>
                                                <?php } elseif ($getRechtenValue == 'by-attribution-nonCommercial-ShareAlike') {?>
                                                    <a href="https://creativecommons.org/licenses/by-nc-sa/4.0/deed.nl" target="_blank">
                                                        <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                             width="64px" height="64px" viewBox="5.5 -3.5 64 64" enable-background="new 5.5 -3.5 64 64" xml:space="preserve">
                                                                <g>
                                                                    <circle fill="transparent" cx="37.785" cy="28.501" r="28.836"/>
                                                                    <path d="M37.441-3.5c8.951,0,16.572,3.125,22.857,9.372c3.008,3.009,5.295,6.448,6.857,10.314
                                                                        c1.561,3.867,2.344,7.971,2.344,12.314c0,4.381-0.773,8.486-2.314,12.313c-1.543,3.828-3.82,7.21-6.828,10.143
                                                                        c-3.123,3.085-6.666,5.448-10.629,7.086c-3.961,1.638-8.057,2.457-12.285,2.457s-8.276-0.808-12.143-2.429
                                                                        c-3.866-1.618-7.333-3.961-10.4-7.027c-3.067-3.066-5.4-6.524-7-10.372S5.5,32.767,5.5,28.5c0-4.229,0.809-8.295,2.428-12.2
                                                                        c1.619-3.905,3.972-7.4,7.057-10.486C21.08-0.394,28.565-3.5,37.441-3.5z M37.557,2.272c-7.314,0-13.467,2.553-18.458,7.657
                                                                        c-2.515,2.553-4.448,5.419-5.8,8.6c-1.354,3.181-2.029,6.505-2.029,9.972c0,3.429,0.675,6.734,2.029,9.913
                                                                        c1.353,3.183,3.285,6.021,5.8,8.516c2.514,2.496,5.351,4.399,8.515,5.715c3.161,1.314,6.476,1.971,9.943,1.971
                                                                        c3.428,0,6.75-0.665,9.973-1.999c3.219-1.335,6.121-3.257,8.713-5.771c4.99-4.876,7.484-10.99,7.484-18.344
                                                                        c0-3.543-0.648-6.895-1.943-10.057c-1.293-3.162-3.18-5.98-5.654-8.458C50.984,4.844,44.795,2.272,37.557,2.272z M37.156,23.187
                                                                        l-4.287,2.229c-0.458-0.951-1.019-1.619-1.685-2c-0.667-0.38-1.286-0.571-1.858-0.571c-2.856,0-4.286,1.885-4.286,5.657
                                                                        c0,1.714,0.362,3.084,1.085,4.113c0.724,1.029,1.791,1.544,3.201,1.544c1.867,0,3.181-0.915,3.944-2.743l3.942,2
                                                                        c-0.838,1.563-2,2.791-3.486,3.686c-1.484,0.896-3.123,1.343-4.914,1.343c-2.857,0-5.163-0.875-6.915-2.629
                                                                        c-1.752-1.752-2.628-4.19-2.628-7.313c0-3.048,0.886-5.466,2.657-7.257c1.771-1.79,4.009-2.686,6.715-2.686
                                                                        C32.604,18.558,35.441,20.101,37.156,23.187z M55.613,23.187l-4.229,2.229c-0.457-0.951-1.02-1.619-1.686-2
                                                                        c-0.668-0.38-1.307-0.571-1.914-0.571c-2.857,0-4.287,1.885-4.287,5.657c0,1.714,0.363,3.084,1.086,4.113
                                                                        c0.723,1.029,1.789,1.544,3.201,1.544c1.865,0,3.18-0.915,3.941-2.743l4,2c-0.875,1.563-2.057,2.791-3.541,3.686
                                                                        c-1.486,0.896-3.105,1.343-4.857,1.343c-2.896,0-5.209-0.875-6.941-2.629c-1.736-1.752-2.602-4.19-2.602-7.313
                                                                        c0-3.048,0.885-5.466,2.658-7.257c1.77-1.79,4.008-2.686,6.713-2.686C51.117,18.558,53.938,20.101,55.613,23.187z"/>
                                                                </g>
                                                            </svg>
                                                        <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                             width="64px" height="64px" viewBox="5.5 -3.5 64 64" enable-background="new 5.5 -3.5 64 64" xml:space="preserve">
                                                                <g>
                                                                    <circle fill="transparent" cx="37.637" cy="28.806" r="28.276"/>
                                                                    <g>
                                                                        <path d="M37.443-3.5c8.988,0,16.57,3.085,22.742,9.257C66.393,11.967,69.5,19.548,69.5,28.5c0,8.991-3.049,16.476-9.145,22.456
                                                                            C53.879,57.319,46.242,60.5,37.443,60.5c-8.649,0-16.153-3.144-22.514-9.43C8.644,44.784,5.5,37.262,5.5,28.5
                                                                            c0-8.761,3.144-16.342,9.429-22.742C21.101-0.415,28.604-3.5,37.443-3.5z M37.557,2.272c-7.276,0-13.428,2.553-18.457,7.657
                                                                            c-5.22,5.334-7.829,11.525-7.829,18.572c0,7.086,2.59,13.22,7.77,18.398c5.181,5.182,11.352,7.771,18.514,7.771
                                                                            c7.123,0,13.334-2.607,18.629-7.828c5.029-4.838,7.543-10.952,7.543-18.343c0-7.276-2.553-13.465-7.656-18.571
                                                                            C50.967,4.824,44.795,2.272,37.557,2.272z M46.129,20.557v13.085h-3.656v15.542h-9.944V33.643h-3.656V20.557
                                                                            c0-0.572,0.2-1.057,0.599-1.457c0.401-0.399,0.887-0.6,1.457-0.6h13.144c0.533,0,1.01,0.2,1.428,0.6
                                                                            C45.918,19.5,46.129,19.986,46.129,20.557z M33.042,12.329c0-3.008,1.485-4.514,4.458-4.514s4.457,1.504,4.457,4.514
                                                                            c0,2.971-1.486,4.457-4.457,4.457S33.042,15.3,33.042,12.329z"/>
                                                                    </g>
                                                                </g>
                                                            </svg>
                                                        <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                             width="64px" height="64px" viewBox="5.5 -3.5 64 64" enable-background="new 5.5 -3.5 64 64" xml:space="preserve">
                                                                <g>
                                                                    <circle fill="transparent" cx="37.47" cy="28.736" r="29.471"/>
                                                                    <g>
                                                                        <path d="M37.442-3.5c8.99,0,16.571,3.085,22.743,9.256C66.393,11.928,69.5,19.509,69.5,28.5c0,8.992-3.048,16.476-9.145,22.458
                                                                            C53.88,57.32,46.241,60.5,37.442,60.5c-8.686,0-16.19-3.162-22.513-9.485C8.644,44.728,5.5,37.225,5.5,28.5
                                                                            c0-8.762,3.144-16.343,9.429-22.743C21.1-0.414,28.604-3.5,37.442-3.5z M12.7,19.872c-0.952,2.628-1.429,5.505-1.429,8.629
                                                                            c0,7.086,2.59,13.22,7.77,18.4c5.219,5.144,11.391,7.715,18.514,7.715c7.201,0,13.409-2.608,18.63-7.829
                                                                            c1.867-1.79,3.332-3.657,4.398-5.602l-12.056-5.371c-0.421,2.02-1.439,3.667-3.057,4.942c-1.622,1.276-3.535,2.011-5.744,2.2
                                                                            v4.915h-3.714v-4.915c-3.543-0.036-6.782-1.312-9.714-3.827l4.4-4.457c2.094,1.942,4.476,2.913,7.143,2.913
                                                                            c1.104,0,2.048-0.246,2.83-0.743c0.78-0.494,1.172-1.312,1.172-2.457c0-0.801-0.287-1.448-0.858-1.943l-3.085-1.315l-3.771-1.715
                                                                            l-5.086-2.229L12.7,19.872z M37.557,2.214c-7.276,0-13.428,2.571-18.457,7.714c-1.258,1.258-2.439,2.686-3.543,4.287L27.786,19.7
                                                                            c0.533-1.676,1.542-3.019,3.029-4.028c1.484-1.009,3.218-1.571,5.2-1.686V9.071h3.715v4.915c2.934,0.153,5.6,1.143,8,2.971
                                                                            l-4.172,4.286c-1.793-1.257-3.619-1.885-5.486-1.885c-0.991,0-1.876,0.191-2.656,0.571c-0.781,0.381-1.172,1.029-1.172,1.943
                                                                            c0,0.267,0.095,0.533,0.285,0.8l4.057,1.83l2.8,1.257l5.144,2.285l16.397,7.314c0.535-2.248,0.801-4.533,0.801-6.857
                                                                            c0-7.353-2.552-13.543-7.656-18.573C51.005,4.785,44.831,2.214,37.557,2.214z"/>
                                                                    </g>
                                                                </g>
                                                            </svg>
                                                        <svg version="1.0" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                             width="64px" height="64px" viewBox="5.5 -3.5 64 64" enable-background="new 5.5 -3.5 64 64" xml:space="preserve">
                                                                <g>
                                                                    <circle fill="transparent" cx="36.944" cy="28.631" r="29.105"/>
                                                                    <g>
                                                                        <path d="M37.443-3.5c8.951,0,16.531,3.105,22.742,9.315C66.393,11.987,69.5,19.548,69.5,28.5c0,8.954-3.049,16.457-9.145,22.514
                                                                            C53.918,57.338,46.279,60.5,37.443,60.5c-8.649,0-16.153-3.143-22.514-9.429C8.644,44.786,5.5,37.264,5.5,28.501
                                                                            c0-8.723,3.144-16.285,9.429-22.685C21.138-0.395,28.643-3.5,37.443-3.5z M37.557,2.272c-7.276,0-13.428,2.572-18.457,7.715
                                                                            c-5.22,5.296-7.829,11.467-7.829,18.513c0,7.125,2.59,13.257,7.77,18.4c5.181,5.182,11.352,7.771,18.514,7.771
                                                                            c7.123,0,13.334-2.609,18.629-7.828c5.029-4.876,7.543-10.99,7.543-18.343c0-7.313-2.553-13.485-7.656-18.513
                                                                            C51.004,4.842,44.832,2.272,37.557,2.272z M23.271,23.985c0.609-3.924,2.189-6.962,4.742-9.114
                                                                            c2.552-2.152,5.656-3.228,9.314-3.228c5.027,0,9.029,1.62,12,4.856c2.971,3.238,4.457,7.391,4.457,12.457
                                                                            c0,4.915-1.543,9-4.627,12.256c-3.088,3.256-7.086,4.886-12.002,4.886c-3.619,0-6.743-1.085-9.371-3.257
                                                                            c-2.629-2.172-4.209-5.257-4.743-9.257H31.1c0.19,3.886,2.533,5.829,7.029,5.829c2.246,0,4.057-0.972,5.428-2.914
                                                                            c1.373-1.942,2.059-4.534,2.059-7.771c0-3.391-0.629-5.971-1.885-7.743c-1.258-1.771-3.066-2.657-5.43-2.657
                                                                            c-4.268,0-6.667,1.885-7.2,5.656h2.343l-6.342,6.343l-6.343-6.343L23.271,23.985L23.271,23.985z"/>
                                                                    </g>
                                                                </g>
                                                            </svg>
                                                    </a>
                                                <?php } ?>

                                            </li>
							            <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="content-btn">
                            <a href="<?php echo get_the_post_thumbnail_url($getPhotoField->ID, 'full'); ?>" class="info-btn full-img-download-btn" download>Download</a>
                        </div>
                    </div>
                </div>

            </div>

		<?php endwhile;
        wp_reset_postdata();
        echo '</div>';
    else:
        echo '<div class="material__items search__items noitemfound">';
        echo '<h3 class="materiaal-no-results">Geen resultaten gevonden</h3>';
        echo '</div>';
	endif;



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

// Show card based on Parameters in URL
function materialen_param_show_card() {

	if (isset($_GET['mc_slug'])) {
	    $get_materiaal_card = get_page_by_path( $_GET['mc_slug'], OBJECT, 'materiaal' ); ?>

		<script>
            jQuery(document).ready(function(){
                console.log(<?php echo $get_materiaal_card->ID; ?>);
                setTimeout(function (){
                    jQuery('#materiaal-<?php echo $get_materiaal_card->ID; ?> .item__single-img').trigger('click');
                }, 1000);
            });
        </script>

	<?php }
}
add_action('wp_footer', 'materialen_param_show_card', 100);

// Setting default value of Date field in ACF
add_filter('acf/load_field/name=date', 'my_acf_default_date');
function my_acf_default_date($field) {
	$field['default_value'] = date('Ymd');
	return $field;
}

add_action('wp_ajax_update_materiaal_card_stats' , 'update_materiaal_card_stats');
add_action('wp_ajax_nopriv_update_materiaal_card_stats','update_materiaal_card_stats');
function update_materiaal_card_stats() {

    $materiaal_ID = $_POST['getMateriaalID'];

//    $materiaal_stats = get_post_meta($materiaal_ID, 'materiaal_clicks', true);
//    if ( ! $materiaal_stats ) {
//	    $materiaal_stats = 0;
//    }
//    $materiaal_stats++;

	//update_post_meta($materiaal_ID, 'materiaal_clicks', $materiaal_stats);

    $material_time = [];

	$materiaal_stats = get_post_meta($materiaal_ID, 'materiaal_clicks', true);

    if ( ! $materiaal_stats ) {
	    array_push($material_time, date('Y-m-d', time()));
    } else {
	    $material_time = $materiaal_stats;
	    array_push($material_time, date('Y-m-d', time()));
    }

	update_post_meta($materiaal_ID, 'materiaal_clicks', $material_time);

}
