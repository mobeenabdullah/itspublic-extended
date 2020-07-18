(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(document).ready(function () {

		$('.itspublic-members').slick({
			appendArrows: '.custom-arrow-buttons',
			prevArrow: '<span class="custom-prev-arrow"><i class="fa fa-long-angle-left"></i></span>',
			nextArrow: '<span class="custom-next-arrow"><i class="fa fa-long-angle-right"></i></span>',
			draggable: false
		});

		$('.itspublic-projects').slick({
			appendArrows: '.projecten__arrows',
			prevArrow: '<span class="custom-prev-arrow"><i class="fa fa-long-angle-left"></i></span>',
			nextArrow: '<span class="custom-next-arrow"><i class="fa fa-long-angle-right"></i></span>',
			draggable: false
		});

		$('.project_types_list').slick({
			slidesToShow: 10,
			slidesToScroll: 1,
			asNavFor: '.itspublic-projects',
			focusOnSelect: true
		});

	});


})( jQuery );