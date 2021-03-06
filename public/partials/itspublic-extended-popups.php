<?php

// Itspublic Team Popup
function itspublic_team_popup() {

	// Check if is frontpage
	if (is_front_page()) { ?>

		<!-- Team Modal -->
		<div id="teamModal" class="modal" style="display: none;">
			<!-- Modal content -->
			<div class="modal-content modal_team_content">
				<!-- Image Box -->
				<div class="teampopup__cover">
					<!-- Image cover -->
                    <div class="teampopup__cover-img">
					<figure class="teampopup__cover-img-figure">
						<img src="" alt="" />
					</figure>
                    <div class="social-icon-cover">
							<div class="icon-social-cover">
								<a href="" target="_blank" class="linkedin-bg linkedin-link">
									<i class="fa fa-linkedin"></i>
									<span>LinkedIn</span>
								</a>
							</div>
							<div class="icon-social-cover">
								<a href="" target="_blank" class="email-link">
									<i class="fa fa-envelope"></i>
									<span>e-mail</span>
								</a>
							</div>
						</div>
                    </div>

					<div class="teampopup__cover-content">
						<span class="teampop-designation"></span>
						<h3 class="teampop-member-name"></h3>
						<div class="teampop-detail"></div>
						

					</div>

				</div>
				<!-- Close btn -->
				<span class="close itspublic__cover-close">
                <svg xmlns="http://www.w3.org/2000/svg" width="13.139" height="13.139" viewBox="0 0 13.139 13.139">
                    <g id="close-icon" data-name="Group 242" transform="translate(1.414 1.414)">
                        <g id="Group_241" data-name="Group 241">
                            <line id="Line_34" data-name="Line 34" x2="10.31" y2="10.31" fill="none" stroke="#000"
                                  stroke-linecap="round" stroke-width="2" />
                            <line id="Line_35" data-name="Line 35" x1="10.31" y2="10.31" fill="none" stroke="#000"
                                  stroke-linecap="round" stroke-width="2" />
                        </g>
                    </g>
                </svg>

            </span>
			</div>
		</div>

	<?php }

	if (is_page('materialen') || is_front_page()) { ?>

        <!-- Materialen Modal -->
        <div id="materialenModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <!-- Image Box -->
                <div class="itspublic__cover">
                    <!-- Image cover -->
                    <figure class="itspublic__cover-img">
                        <img src="<?php echo plugin_dir_url(__FILE__); ?>../images/popup.jpg" alt="" />

                        <!-- Information mark -->
                    <div class="information__box-icon"><i class="fas fa-info-circle"></i></div>

                    <!-- Information box content -->
                    <div class="information__box-content"></div>

                    </figure>                    

                </div>
                <!-- Itspublic Popup Content -->
                <div class="itspublic__popcontent">
                    <div class="taxonomies">
                        <ul>
                            <li class="materiaal-popup-date"><i class="far fa-calendar-alt"></i> <span>January 2020</span></li>
                            <li class="materiaal-popup-categorie"><i class="fas fa-folder-open"></i> <span>Projectinzichten</span></li>
                        </ul>
                    </div>
                    <div class="materialPop_heading">
                        <h3>Het optimale egeleidingsproces in de bijstand</h3>
                        <a href="https://www.google.com" class="link_tooltip" data-tooltip="Copy Link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" style="fill:rgba(0, 0, 0, .25);transform:;-ms-filter:"><path d="M4.222 19.778c.975.975 2.255 1.462 3.535 1.462 1.281-.001 2.562-.487 3.536-1.462l2.828-2.829-1.414-1.414-2.828 2.829c-1.169 1.167-3.072 1.169-4.243 0-1.169-1.17-1.169-3.073 0-4.243l2.829-2.828L7.051 9.879l-2.829 2.828C2.273 14.656 2.273 17.829 4.222 19.778zM19.778 11.293c1.948-1.949 1.948-5.122 0-7.071-1.95-1.95-5.123-1.948-7.071 0L9.879 7.051l1.414 1.414 2.828-2.829c1.17-1.167 3.073-1.169 4.243 0 1.169 1.17 1.169 3.073 0 4.243l-2.829 2.828 1.414 1.414L19.778 11.293z"></path><path transform="rotate(-134.999 12 12)" d="M11 5.999H13V18H11z"></path></svg>
                        </a>
                    </div>
                    <div class="popup_materiaal_content">
                        <p>
                            Nunc scelerisque tincidunt elit. Vestibulum non mi ipsum. Cras
                            pretium suscipit tellus sit amet aliquet. Vestibulum maximus lacinia
                            massa non porttitor. Pellentesque vehicula est a lorem gravida
                            bibendum. Proin tristique diam ut urna pharetra, ac rhoncus elit
                            elementum. Proin vitae purus ultrices, dignissim turpis ut, mattis
                            eros. Maecenas ornare molestie urna, hendrerit venenatis sem.
                        </p>
                        <p>
                            Nunc scelerisque tincidunt elit. Vestibulum non mi ipsum. Cras
                            pretium suscipit tellus sit amet aliquet. Vestibulum maximus lacinia
                            massa non porttitor. Pellentesque vehicula est a lorem gravida
                            bibendum. Proin tristique diam ut urna pharetra, ac rhoncus elit
                            elementum. Proin vitae purus ultrices, dignissim turpis ut, mattis
                            eros. Maecenas ornare molestie urna, hendrerit venenatis sem.
                        </p>
                    </div>
                </div>
                <!-- Itspublic Popup Footer -->
                <div class="itspublic__footer">

                    <div class="itspublic__footer-members-list"></div>

                    <div class="itspublic__footer-download"></div>
                </div>

                <!-- Close btn -->
                <span class="close itspublic__cover-close">
                      <img src="<?php echo plugin_dir_url(__FILE__); ?>../images/close.svg" alt="" />
                    </span>  
            </div>
        </div>

    <?php }

}

add_action('wp_footer', 'itspublic_team_popup');