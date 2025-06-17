(function($) {
	"use strict";
	var wow_init = {
	  init: function() {
		$(".grid").isotope({
		  itemSelector: ".grid-item",
		});
		new WOW().init();
	  },
	};
	$(document).ready(function() {
	  wow_init.init();
	});
  })(jQuery);  