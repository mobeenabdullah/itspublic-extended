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
									<span>Email</span>
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

	if (is_page('materialen')) { ?>

        <!-- Materialen Modal -->
        <div id="materialenModal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <!-- Image Box -->
                <div class="itspublic__cover">
                    <!-- Image cover -->
                    <figure class="itspublic__cover-img">
                        <img src="<?php echo plugin_dir_url(__FILE__); ?>../images/popup.jpg" alt="" />
                    </figure>
                    <!-- Avatar -->
                    <div class="itspublic__cover-avatar">
                        <a href="#" class="profile_img popoverbtn">
                            <img src="<?php echo plugin_dir_url(__FILE__); ?>../images/avatar-1.jpg" alt="" />
                        </a>
                        <a href="#" class="profile_img popoverbtn">
                            <img src="<?php echo plugin_dir_url(__FILE__); ?>../images/avatar-2.jpg" alt="" />
                        </a>
                        <a href="#">
                            <img src="<?php echo plugin_dir_url(__FILE__); ?>../images/avatar-3.jpg" alt="" />
                        </a>
                    </div>
                    <!-- Close btn -->
                    <span class="close itspublic__cover-close">
                      <img src="<?php echo plugin_dir_url(__FILE__); ?>../images/close.svg" alt="" />
                    </span>

                    <!-- Material Label -->
                    <div class="itspublic__cover-label">Projectinzichten</div>

                    <div class="popoverbox">
                        <div class="popoverbox__title">
                            Contact Persons
                        </div>
                        <div class="persons__ul">
                            <li>
                                <a href="#">
                                    Hugo en Breejen
                                    <span class="person-email">hugo.denbreejen@itspublic.nl</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Eva Nivard
                                    <span class="person-email">eva.nivard@itspublic.nl</span>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    Kees van der Meeren
                                    <span class="person-email">kees@itspublic.nl</span>
                                </a>
                            </li>
                        </div>
                    </div>
                </div>
                <!-- Itspublic Popup Content -->
                <div class="itspublic__popcontent">
                    <h3>Het optimale egeleidingsproces in de bijstand</h3>
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
                <!-- Itspublic Popup Footer -->
                <div class="itspublic__footer">
                    <div class="itspublic__footer-date">
                        <img src="images/calendar.svg" alt="" />
                        <span>June, 2020</span>
                    </div>
                    <div class="itspublic__footer-download">
                        <span>Download</span>
                        <a href="#"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/pop-pdf.svg" alt="" /></a>
                        <a href="#"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/pop-doc.svg" alt="" /></a>
                        <a href="#"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/pop-xls.svg" alt="" /></a>
                        <a href="#"><img src="<?php echo plugin_dir_url(__FILE__); ?>../images/pop-ppt.svg" alt="" /></a>
                    </div>
                </div>
            </div>
        </div>

    <?php }

}

add_action('wp_footer', 'itspublic_team_popup');