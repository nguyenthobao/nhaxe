$(document).ready(function()
{
	"use strict";
    /* SlideShow OWL */
	$(".slider_introduction_owl").owlCarousel({
		navigation: true,
		items:3,
		slideSpeed : 200,
		paginationSpeed : 800,
		rewindSpeed : 1000,
		singleItem : true,
		transitionStyle : "fade",
		//Autoplay
		autoPlay : true,
		responsive:true,
		navigationText:false
	});

	$(".partner_inner_owl").owlCarousel({
		navigation: true,
		items:6,
		slideSpeed : 200,
		paginationSpeed : 800,
		rewindSpeed : 1000,
		//Autoplay
		autoPlay : true,
		itemsCustom:[[480,2],[320,1],[768,3],[767,3],[991,3],[1200,5]],
		responsive:true,
		navigationText:false

	});		
});