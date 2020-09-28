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
					<figure class="teampopup__cover-img">
						<img src="" alt="" />
					</figure>

					<div class="teampopup__cover-content">
						<span class="teampop-designation"></span>
						<h3 class="teampop-member-name"></h3>
						<div class="teampop-detail"></div>
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
                    <h3>Het optimale egeleidingsproces in de bijstand</h3>
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