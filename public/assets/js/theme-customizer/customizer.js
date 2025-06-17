(function ($) {
  if (localStorage.getItem("color"))
    $("#color").attr(
      "href",
      "../assets/css/" + localStorage.getItem("color") + ".css"
    );
  $(
    '<div class="sidebar-pannle-main"><ul><li class="cog-click icon-btn btn-primary" id="cog-click"><i class="fa-solid fa-spin fa-cog"></i></li></ul></div><section class="setting-sidebar"><div class="customizer-header"><div class="theme-title"><div><h3>Preview Settings</h3><p class="mb-0">Try It Real Time<i class="fa-solid fa-thumbs-up fa-fw"></i></p></div><div class="flex-grow-1"><a class="icon-btn btn-outline-light button-effect pull-right cog-close" id="cog-close"><i class="fa-solid fa-xmark fa-fw"></i></a></div></div></div><div class="customizer-body"><div class="mb-3 p-2 rounded-3 b-t-primary border-3"><div class="color-header mb-2"><h4>Theme color mode:</h4><p >Choose between 3 different mix layout.</p></div><div class="color-body d-flex align-items-center justify-space-between"><div class="color-img"><img class="img-fluid" src="../assets/images/customizer/light.png" alt=""><div class="customizer-overlay"></div><div class="button color-btn light-setting"><a href="javascript:void(0)">LIGHT</a></div></div><div class="color-img mx-1"><img class="img-fluid" src="../assets/images/customizer/dark.png" alt=""><div class="customizer-overlay"></div><div class="button color-btn dark-setting"><a href="javascript:void(0)">Dark</a></div></div><div class="color-img"><img class="img-fluid" src="../assets/images/customizer/mix.png" alt=""><div class="customizer-overlay"></div><div class="button color-btn mix-setting"><a href="javascript:void(0)">Mix</a></div></div></div></div><div class="mb-3 p-2 rounded-3 b-t-primary border-3"><div class="sidebar-icon mb-2"><h4>Sidebar icon:</h4><p >Choose between 2 different sidebar icon.</p></div><div class="sidebar-body form-check radio ps-0"><ul class="radio-wrapper"><li class="default-svg"><input class="form-check-input" id="radio-icon5" type="radio" name="radio2" value="option2" checked=""><label class="form-check-label" for="radio-icon5"><svg class="stroke-icon"><use href="../assets/svg/icon-sprite.svg#stroke-icons"></use></svg><span>Stroke</span></label></li><li class="colorfull-svg"><input class="form-check-input" id="radio-icon6" type="radio" name="radio2" value="option2"><label class="form-check-label" for="radio-icon6"><svg class="stroke-icon"><use href="../assets/svg/icon-sprite.svg#stroke-icons"></use><span>Colorfull icon</span></label></li></ul></div></div><div class="mb-3 p-2 rounded-3 b-t-primary border-3"><div class="theme-layout mb-2"><h4>Layout type:</h4><p >Choose between 3 different layout types.</p></div><div class="radio-form checkbox-checked"><div class="form-check ltr-setting"><input class="form-check-input" id="flexRadioDefault1" type="radio" name="flexRadioDefault" checked=""><label class="form-check-label" for="flexRadioDefault1">LTR</label></div><div class="form-check rtl-setting"><input class="form-check-input" id="flexRadioDefault2" type="radio" name="flexRadioDefault"><label class="form-check-label" for="flexRadioDefault2">RTL</label></div><div class="form-check box-setting"><input class="form-check-input" id="flexRadioDefault3" type="radio" name="flexRadioDefault"><label class="form-check-label" for="flexRadioDefault3">Box</label></div></div></div><div class="mb-3 p-2 rounded-3 b-t-primary border-3"><div class="sidebar-type mb-2"><h4>Sidebar type:</h4><p >Choose between 2 different sidebar types.</p></div><form><div class="sidebar-body form-check radio ps-0"><ul class="radio-wrapper"><li class="vertical-setting"><input class="form-check-input" id="radio-icon" type="radio" name="radio2" value="option2" checked=""><label class="form-check-label" for="radio-icon"><span>Vertical</span></label></li><li class="horizontal-setting"><input class="form-check-input" id="radio-icon4" type="radio" name="radio2" value="option2"><label class="form-check-label" for="radio-icon4"><span>Horizontal</span></label></li></ul></div></form></div><div class="customizer-color mb-3 p-2 rounded-3 b-t-primary border-3"><div class="color-picker mb-2"><h4>Unlimited color:</h4></div><ul class="layout-grid"><li class="color-layout" data-attr="color-1" data-primary="#134D80" data-secondary="#f39159"><div></div></li><li class="color-layout" data-attr="color-2" data-primary="#57375D" data-secondary="#FF9B82"><div></div></li><li class="color-layout" data-attr="color-3" data-primary="#0766AD" data-secondary="#29ADB2"><div></div></li><li class="color-layout" data-attr="color-4" data-primary="#025464" data-secondary="#E57C23"><div></div></li><li class="color-layout" data-attr="color-5" data-primary="#884A39" data-secondary="#C38154"><div></div></li><li class="color-layout" data-attr="color-6" data-primary="#0C356A" data-secondary="#FFC436"><div></div></li></ul></div></div><div class="customizer-footer"><div class="d-flex align-items-center justify-content-around"><a class="btn btn-primary" href="https://themeforest.net/user/pixelstrap/portfolio" target="_blank"><i class="fa-solid fa-cart-shopping"></i>Buy Now</a><a class="btn btn-primary" href="https://docs.pixelstrap.net/admin/admiro/document/" target="_blank"><i class="fa-solid fa-file-arrow-up"></i>Document</a></div></div></section>'
  ).appendTo($("body"));
  (function () {})();
/**==COLOR_PICKER==**/
  $(document).ready(function () {
    $(".customizer-color li").on("click", function () {
      $(".customizer-color li").removeClass("active");
      $(this).addClass("active");
      var color = $(this).attr("data-attr");
      var primary = $(this).attr("data-primary");
      var secondary = $(this).attr("data-secondary");
      localStorage.setItem("color", color);
      localStorage.setItem("primary", primary);
      localStorage.setItem("secondary", secondary);
      localStorage.removeItem("dark");
      $("#color").attr("href", "../assets/css/" + color + ".css");
      $(".dark-only").removeClass("dark-only");
      location.reload(true);
    });
  });
  if (localStorage.getItem("primary") != null) {
    document.documentElement.style.setProperty(
      "--theme-default",
      localStorage.getItem("primary")
    );
  }
  if (localStorage.getItem("secondary") != null) {
    document.documentElement.style.setProperty(
      "--theme-secondary",
      localStorage.getItem("secondary")
    );
  }
/**==SETTING-SIDEBAR-TOGGLE==**/
  $(document).ready(function () {
    document.getElementById("cog-click").addEventListener("click", function () {
      var settingSidebar = document.querySelector(".setting-sidebar");
      settingSidebar.classList.add("open");
    });
    document.getElementById("cog-close").addEventListener("click", function () {
      var settingSidebar = document.querySelector(".setting-sidebar");
      settingSidebar.classList.remove("open");
    });
/**==LTR/RTL/BOX_LAYOUT==**/
    document
      .querySelector(".ltr-setting")
      .addEventListener("click", function () {
        document.body.classList.remove("rtl", "ltr", "box-layout", "dark-only");
        document.documentElement.setAttribute("dir", "ltr");
      });
    document
      .querySelector(".rtl-setting")
      .addEventListener("click", function () {
        document.body.classList.remove("ltr", "rtl", "box-layout", "dark-only");
        document.documentElement.setAttribute("dir", "rtl");
      });
    document
      .querySelector(".box-setting")
      .addEventListener("click", function () {
        document.body.classList.remove("rtl", "ltr");
        document.body.classList.add("box-layout");
        document.documentElement.removeAttribute("dir");
      });
/**==COLORFULL SVG==**/
    document
      .querySelector(".colorfull-svg")
      .addEventListener("click", function () {
        const pageSidebar = document.querySelector(".page-sidebar");
        pageSidebar.classList.add("iconcolor-sidebar");
        pageSidebar.setAttribute("data-sidebar-layout", "iconcolor-sidebar");
      });
/**==STROKE SVG==**/
    document.querySelectorAll(".default-svg").forEach(function (element) {
      element.addEventListener("click", function () {
        var pageSidebarElements = document.querySelectorAll(".page-sidebar");
        for (var i = 0; i < pageSidebarElements.length; i++) {
          pageSidebarElements[i].setAttribute(
            "data-sidebar-layout",
            "stroke-svg"
          );
          pageSidebarElements[i].classList.remove("iconcolor-sidebar");
        }
      });
    });
/**==horizontal-sidebar==**/
  function handleHorizontalResize() {
    if (window.innerWidth <= 1200) {
      $(".page-wrapper").removeClass("horizontal-sidebar");
      $(".page-wrapper").addClass("compact-wrapper");
    } else {
      $(".page-wrapper").removeClass("compact-wrapper");
      $(".page-wrapper").addClass("horizontal-sidebar");
    }
  }
  $(".horizontal-setting").click(function () {
    handleHorizontalResize();
    $(window).off("resize", handleHorizontalResize);
    $(window).on("resize", handleHorizontalResize);
  });
  $(".vertical-setting").click(function () {
    $(".page-wrapper").removeClass("horizontal-sidebar");
    $(".page-wrapper").addClass("compact-wrapper");
    $(window).off("resize", handleHorizontalResize);
    location.reload();
  });
/**==LIGHT/DARK==**/
    $(".light-setting").click(function () {
      $("body").attr("data-theme", "light");
      document.body.classList.add("light");
      document.body.classList.remove("dark-only");
      document.body.classList.remove("dark-sidebar");
    });
    $(".dark-setting").click(function () {
      $("body").attr("data-theme", "dark-only");
      document.body.classList.add("dark-only");
      document.body.classList.remove("light");
      document.body.classList.remove("dark-sidebar");
    });
  });
/**==DARK SIDEBAR==**/
  document.addEventListener("DOMContentLoaded", function () {
    const toggleDarkSidebarButton = document.querySelector(".mix-setting");
    const htmlTag = document.documentElement;
    toggleDarkSidebarButton.addEventListener("click", function () {
      htmlTag.setAttribute("data-theme", "dark-sidebar");
      document.body.classList.remove("dark-only", "light");
      document.body.classList.add("dark-sidebar");
    });
  });
/**==HORIZONTAL SIDEBAR ARROW==**/
  var view = $("#main-sidebar");
  var move = "500px";
  var leftsideLimit = -500;
  var getMenuWrapperSize = function () {
    return $(".page-sidebar").innerWidth();
  };
  var menuWrapperSize = getMenuWrapperSize();
  if (menuWrapperSize >= "1660") {
    var sliderLimit = -3250;
  } else if (menuWrapperSize >= "1440") {
    var sliderLimit = -3250;
  } else {
    var sliderLimit = -4500;
  }
  $("#left-arrow").addClass("disabled");
  $("#right-arrow").click(function () {
    var currentPosition = parseInt(view.css("marginLeft"));
    if (currentPosition >= sliderLimit) {
      $("#left-arrow").removeClass("disabled");
      view.stop(false, true).animate(
        {
          marginLeft: "-=" + move,
        },
        {
          duration: 400,
          complete: function () {
            if (parseInt(view.css("marginLeft")) == -3250) {
              $("#right-arrow").addClass("disabled");
            }
          },
        }
      );
      if (currentPosition == sliderLimit) {
        $(this).addClass("disabled");
        console.log("sliderLimit", sliderLimit);
      }
    }
  });
  $("#left-arrow").click(function () {
    var currentPosition = parseInt(view.css("marginLeft"));
    if (currentPosition < 0) {
      view.stop(false, true).animate(
        {
          marginLeft: "+=" + move,
        },
        {
          duration: 400,
        }
      );
      $("#right-arrow").removeClass("disabled");
      $("#left-arrow").removeClass("disabled");
      if (currentPosition >= leftsideLimit) {
        $(this).addClass("disabled");
      }
    }
  });
})(jQuery);