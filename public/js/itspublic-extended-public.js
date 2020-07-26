// Vanilla stuff

// Show quick results on keyup event
document.querySelector('#search_field').addEventListener('keyup', showQuickResults);

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
(function( $ ) {
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

		$('.item__single-img').on('click', showMaterialenPopup);
		$('.item__single-title').on('click', showMaterialenPopup);

		function showMaterialenPopup() {

			const materialenModal = $('#materialenModal');
			materialenModal.show();
		}

		$('.itspublic__cover-close').on('click', function () {
			$('#materialenModal').hide();
		});

		$('.itspublic__cover-avatar a').hover(function () {
			$('.popoverbox').show();
		});

		$('.itspublic__cover-img').mouseout(function () {
			$('.popoverbox').hide();
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

	});


})( jQuery );