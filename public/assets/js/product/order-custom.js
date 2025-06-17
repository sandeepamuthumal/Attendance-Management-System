
    "use strict";
    $(document).on("click", function (e) {
      var outside_space = $(".outside");
      if (
        !outside_space.is(e.target) &&
        outside_space.has(e.target).length === 0
      ) {
        $(".menu-to-be-close").removeClass("d-block");
        $(".menu-to-be-close").css("display", "none");
      }
    });
  
    $(".prooduct-details-box .close").on("click", function (e) {
      var tets = $(this).parent().parent().parent().parent().addClass("d-none");
      console.log(tets);
    });
  
    if ($(".page-wrapper").hasClass("horizontal-wrapper")) {
      $(".sidebar-list").hover(
        function () {
          $(this).addClass("hoverd");
        },
        function () {
          $(this).removeClass("hoverd");
        }
      );
      $(window).on("scroll", function () {
        if ($(this).scrollTop() < 600) {
          $(".sidebar-list").removeClass("hoverd");
        }
      });
    }
