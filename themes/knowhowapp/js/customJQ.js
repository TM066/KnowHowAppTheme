(function ($) {
Drupal.behaviors.knowhowapp= {
attach: function(context, settings) {
	$(document).foundation({
     tab: {
       callback : function (tab) {
         console.log(tab);
       }
     }
   });

	$(document).foundation({
     offcanvas: {
       callback : function (tab) {
         console.log(offcanvas);
       }
     }
   });

	$(document).foundation({
     abide: {
       callback : function (tab) {
         console.log(abide);
       }
     }
   });


   if ($(".masonry-item").length>0) {
	var $container = $('#container');
	// initialize Masonry after all images have loaded
	$container.imagesLoaded( function() {
	  $container.masonry();
	});
   }

   
 $(".form-item-select-roles").detach().insertAfter("#edit-field-userjobtitle-und-autocomplete-aria-live");


}};})(jQuery);
