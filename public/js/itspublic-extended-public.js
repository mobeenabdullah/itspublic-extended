// jQuery stuff
(function ($) {
	'use strict';

	$(document).ready(function () {

		$('.itspublic-members-slider').slick({
			appendArrows: '.custom-arrow-buttons',
			prevArrow: '<span class="custom-prev-arrow"><i class="fa fa-arrow-left"></i></span>',
			nextArrow: '<span class="custom-next-arrow"><i class="fa fa-arrow-right"></i></span>',
			draggable: false
		});

		$('.itspublic-projects').slick({
			appendArrows: '.projecten__arrows',
			prevArrow: '<span class="projecten__arrows-left arrowstyle"><i class="fa fa-arrow-left"></i></span>',
			nextArrow: '<span class="projecten__arrows-right arrowstyle"><i class="fa fa-arrow-right"></i></span>',
			draggable: false
		});

		$('.project_types_list').slick({
			slidesToShow: 10,
			slidesToScroll: 1,
			asNavFor: '.itspublic-projects',
			focusOnSelect: truez
		});

		$('.material__items').on('click', '.item__single-img', showMaterialenPopup);
		$('.material__items').on('click', '.item__single-title', showMaterialenPopup);
		$('.material__items').on('click', '.item__single-desc', showMaterialenPopup);
		$('#searchResult').on('click', '.item__single-img', showMaterialenPopup);
		$('#searchResult').on('click', '.item__single-title', showMaterialenPopup);
		$('#searchResult').on('click', '.item__single-desc', showMaterialenPopup);

		function showMaterialenPopup() {

			$('.item__single').removeClass('active-item');
			$(this).closest('.item__single').addClass('active-item');

			const materialenModal = $('#materialenModal');
			const getImageURL = $('.active-item .materialen-hidden-fields .img-url').text();
			const getFullImageURL = $('.active-item .materialen-hidden-fields .img-url-full').text();
			const getMateriaalTitle = $('.active-item .materialen-hidden-fields .materiaal-title').text();
			const getCategorieName = $('.active-item .materialen-hidden-fields .category-name').text();
			const getMateriaalContent = $('.active-item .materialen-hidden-fields .materiaal-content').html();
			const getMateriaalDate = $('.active-item .materialen-hidden-fields .materiaal-date').text();
			const getMateriaalDownloads = $('.active-item .item__single-attachements').html();
			const getMateriaalMembers = $('.active-item .item__single-members-list').html();
			const getMateriaalImageInfo = $('.active-item .information-box-wrapper').html();

			const materiaalPopupImage = $('#materialenModal .itspublic__cover-img img');
			const materiaalFullImageDownload = $('#materialenModal .full-img-download-btn');
			const materiaalPopupTitle = $('#materialenModal .itspublic__popcontent h3');
			const materiaalPopupCategorieName = $('#materialenModal .taxonomies .materiaal-popup-categorie span');
			const materiaalPopupContent = $('#materialenModal .popup_materiaal_content');
			const materiaalPopupDate = $('#materialenModal .taxonomies .materiaal-popup-date span');
			const materiaalPopupDownloads = $('#materialenModal .itspublic__footer-download');
			const materiaalPopupMembers = $('#materialenModal .itspublic__footer-members-list');
			const materiaalImageInfo = $('#materialenModal .information__box-content');

			materiaalPopupImage.attr('src', getImageURL);
			materiaalFullImageDownload.attr('href', getFullImageURL);
			materiaalPopupTitle.text(getMateriaalTitle);
			materiaalPopupCategorieName.text(getCategorieName);
			materiaalPopupContent.html(getMateriaalContent);
			materiaalPopupDate.text(getMateriaalDate);
			materiaalPopupDownloads.html('<span>Download</span>' + getMateriaalDownloads);
			materiaalPopupMembers.html(getMateriaalMembers);
			materiaalImageInfo.html(getMateriaalImageInfo);

			materialenModal.show();
		}

		$('.itspublic__cover-close').on('click', function () {
			$('#materialenModal').hide();
		});

		$('.itspublic__footer-members-list').hover(function () {
			$('.popoverbox').addClass('showpopover');
		});

		$('.itspublic__footer').mouseleave(function () {
			$('.popoverbox').removeClass('showpopover');
		});

		$('.information__box-icon').hover(function () {
			$('.information__box-content').addClass('showpopover');
		});

		$('.information__box-content').mouseleave(function () {
			$('.information__box-content').removeClass('showpopover');
		});

		// Show quick results on keyup event
		var edQuickResults = null;
		$('#search_field').on('keyup', function() {

			$('.quickSearchPreloader').addClass('showPreloader');

			if(edQuickResults) clearTimeout(edQuickResults);

			edQuickResults = setTimeout(function(){
				showQuickResults();
			}, 500);

		});

		function showQuickResults() {
			const searchValue = document.querySelector('#search_field').value;

			if (searchValue.length > 0) {
				document.querySelector('#searchResult').className = 'showSearchbox';
			} else {
				document.querySelector('#searchResult').className = '';
			}

			var searrchAllLink = document.location + 'materialen/' + '?ms=' +searchValue;

			$.ajax({
				url: ajax_object.ajax_url,
				type: 'post',
				data: { action: 'data_fetch_hero', keyword: searchValue},
				success: function(data) {
					$('#searchResult').html( data );

					let quick_search_filter = `
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
									Bekijk alle resultaten
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
					`;

					$('#searchResult').append(quick_search_filter);

					$('.search__filters-viewallresult .search-btn').attr('href', searrchAllLink);

					$('.searchbox__cover-form').attr('action', searrchAllLink);
				}
			});

			$('.quickSearchPreloader').removeClass('showPreloader');
		}

		$('.categorieen .filter_checkbox_field').on('change', changeCategorieFilter);

		function changeCategorieFilter() {

			$('.categorieen .filter_checkbox_field').not(this).prop('checked', false);

		}

		$('#categories_dropdown_filter').on('change', changeCategorieFilterFromDropDown);

		function changeCategorieFilterFromDropDown() {

			$('.categorieen .filter_checkbox_field').prop('checked', false);

			const getSelectedCategorie = $('#categories_dropdown_filter option:selected').attr('value');
			console.log(getSelectedCategorie);

			$('.categorieen #' +  getSelectedCategorie).prop('checked', true).change();

			if ($('#categories_dropdown_filter').val() === 'showall') {
				$('.categorieen .filter_checkbox_field').prop('checked', false).change();
			}

		}

		$('.member-img').on('click', showTeamPopup);
		$('.member-name').on('click', showTeamPopup);
		$('.member-more-details a').on('click', showTeamPopup);

		function showTeamPopup() {

			$('.itspubic-single-member').removeClass('current-member');
			$(this).closest('.itspubic-single-member').addClass('current-member');

			const memberImageUrl = $('.current-member .member-img img').attr('src');
			const memberName = $('.current-member .member-name').text();
			const memberDesignation = $('.current-member .member-designation').text();
			const memberInfoText = $('.current-member .member-info-full').html();
			const memberEmail = $('.current-member .member-email a').attr('href');
			const memberLinkedInURL = $('.current-member .member-linkedin a').attr('href');

			const teamModal = $('#teamModal');
			const teamModalImage = $('#teamModal .teampopup__cover-img img');
			const teamModalName = $('#teamModal .teampop-member-name');
			const teamModalDesignation = $('#teamModal .teampop-designation');
			const teamModalText = $('#teamModal .teampop-detail');
			const teamModalEmail = $('#teamModal .email-link');
			const teamModalLinkedInURL = $('#teamModal .linkedin-link');

			teamModalImage.attr('src', memberImageUrl);
			teamModalName.text(memberName);
			teamModalDesignation.text(memberDesignation);
			teamModalText.html(memberInfoText);
			teamModalEmail.attr('href', memberEmail);
			teamModalLinkedInURL.attr('href', memberLinkedInURL);

			teamModal.show();
		}

		$('.itspublic__cover-close').on('click', function () {
			$('#teamModal').hide();
		});

		$('.itspublic-projects').on('afterChange', function (event, slick, currentSlide) {
			$('.project_types_list .slick-slide').removeClass('slick-current');
			$('.project_types_list [data-slick-index=' + currentSlide + ']').addClass('slick-current');
		});

		fetchResults();

		var edFetchResults = null;
		$('#materialenPageSearchInput').on('keyup', function (){
			$('.materialenSearchPreloader').addClass('showPreloader');
			$('.material__items').addClass('material__items-overlay');

			if(edFetchResults) clearTimeout(edFetchResults);

			edFetchResults = setTimeout(function(){
				fetchResults();
			}, 500);
		});

		$('.itspublic__sidebar-widget input[type="checkbox"]').on('change', fetchResults);

		function fetchResults(){

			var keyword = jQuery('#materialenPageSearchInput').val();

			let getOnderwerpen = (function() {
				let onderwerpen = [];
				$(".onderwerpen .filter_checkbox_field").each(function() {
					onderwerpen.push(this.value);
				});
				return onderwerpen;
			})();

			let getCategorieen = (function() {
				let categorieen = [];
				$(".categorieen .filter_checkbox_field").each(function() {
					categorieen.push(this.value);
				});
				return categorieen;
			})();

			let getFiletypes = (function() {
				let filetypes = [];
				$(".filetype .filter_checkbox_field").each(function() {
					filetypes.push(this.value);
				});
				return filetypes;
			})();

			let getOnderwerpenSelected = (function() {
				let onderwerpenSelected = [];
				$(".onderwerpen .filter_checkbox_field:checked").each(function() {
					onderwerpenSelected.push(this.value);
				});
				return onderwerpenSelected;
			})();

			let getCategorieenSelected = (function() {
				let categorieenSelected = [];
				$(".categorieen .filter_checkbox_field:checked").each(function() {
					categorieenSelected.push(this.value);
				});
				return categorieenSelected;
			})();

			let getFiletypesSelected = (function() {
				let filetypesSelected = [];
				$(".filetype .filter_checkbox_field:checked").each(function() {
					filetypesSelected.push(this.value);
				});
				return filetypesSelected;
			})();

			if(keyword == ""){
				$.ajax({
					url: ajax_object.ajax_url,
					type: 'post',
					data: { action: 'data_fetch_all', getOnderwerpen, getCategorieen, getFiletypes, getOnderwerpenSelected, getCategorieenSelected, getFiletypesSelected},
					success: function(data) {
						$('.material__items').html( data );
					}
				});
			} else {
				$.ajax({
					url: ajax_object.ajax_url,
					type: 'post',
					data: { action: 'data_fetch', keyword: keyword, getOnderwerpen, getCategorieen, getFiletypes, getOnderwerpenSelected, getCategorieenSelected, getFiletypesSelected  },
					success: function(data) {

						$('.material__items').html( data );
					}
				});
			}

			$('.materialenSearchPreloader').removeClass('showPreloader');
			$('.material__items').removeClass('material__items-overlay');

		}

		$('#searchForm').submit(function (e){
			e.preventDefault();
		});

		$('.searchbox__cover-form').submit(function (e){
			e.preventDefault();
			$(".search__filters-viewallresult a")[0].click();
		});

		$('.searchbox__cover-form .search-btn').on('click', function (){
			$(".search__filters-viewallresult a")[0].click();
		});

		$('.filter-collapse-btn i.fa').on('click', function() {
			$(this).toggleClass('fa-plus-square')

			$(this).closest('.itspublic__sidebar-title').siblings().toggleClass('display-hide');
		});

		// Typewriter Effect
		var ph = "Zoek hier naar publicaties, trainingen en methodieken. Bijvoorbeeld 'onderwijs' of 'storytelling'",
			searchBar = $('#search_field'),

			phCount = 0;

		function randDelay(min, max) {
			return Math.floor(Math.random() * (max-min+1)+min);
		}

		function printLetter(string, el) {
			var arr = string.split(''),
				input = el,
				origString = string,
				curPlace = $(input).attr("placeholder"),
				placeholder = curPlace + arr[phCount];

			setTimeout(function(){
				$(input).attr("placeholder", placeholder);
				phCount++;
				if (phCount < arr.length) {
					printLetter(origString, input);
				}
			}, randDelay(30, 60));
		}

		function placeholder() {
			$(searchBar).attr("placeholder", "");
			printLetter(ph, searchBar);
		}
		placeholder();

		// Hiding Popup on ESC Key
		$( document ).on( 'keydown', function ( e ) {
			if ( e.keyCode === 27 ) { // ESC
				$( '.modal' ).hide();
			}
		});

	});




})(jQuery);


// close on outside of modal
//var modal = document.getElementById("teamModal");
const modal = document.querySelector('#teamModal');
const modalMaterial = document.querySelector('#materialenModal');

// When the user clicks anywhere outside of the modal, close it
window.onclick = function (e) {
	if (e.target == modal) {
		modal.style.display = "none";
	}
	if (e.target == modalMaterial) {
		modalMaterial.style.display = "none";
	}
};