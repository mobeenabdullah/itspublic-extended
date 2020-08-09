// Vanilla stuff

// Show quick results on keyup event
//document.querySelector('#search_field').addEventListener('keyup', showQuickResults);

function showQuickResults() {
	const searchValue = document.querySelector('#search_field').value;
	if (searchValue.length > 0) {
		document.querySelector('#searchResult').className = 'showSearchbox';
	} else {
		document.querySelector('#searchResult').className = '';
	}
}

// // Show Team Popup
// document.querySelector('.itspubic-single-member').addEventListener('click', showTeamPopup);
//
// function showTeamPopup(e) {
//
// 	//document.querySelector('.itspubic-single-member').className = 'itspubic-single-member';
//
// 	//this.className = 'itspubic-single-member active-member';
//
// 	console.log(e.target);
// }

// jQuery stuff
(function ($) {
	'use strict';

	$(document).ready(function () {

		$('.itspublic-members').slick({
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
			focusOnSelect: true
		});

		$('.material__items').on('click', '.item__single-img', showMaterialenPopup);
		$('.material__items').on('click', '.item__single-title', showMaterialenPopup);

		function showMaterialenPopup() {

			const materialenModal = $('#materialenModal');
			materialenModal.show();
		}

		$('.itspublic__cover-close').on('click', function () {
			$('#materialenModal').hide();
		});

		$('.itspublic__footer-avatar a').hover(function () {
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
		$('#materialenPageSearchInput').on('keyup', fetchResults);
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
				$(".filetypes .filter_checkbox_field").each(function() {
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
				$(".filetypes .filter_checkbox_field:checked").each(function() {
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


		}

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

