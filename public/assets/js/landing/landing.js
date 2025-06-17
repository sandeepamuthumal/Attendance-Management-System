(function () {
/*=====================
        01 Tap to top js
    ==========================*/
const button = document.querySelector(".tap-top");
const displayButton = () => {
  window.addEventListener("scroll", () => {
    if (window.scrollY > 100) {
      button.style.display = "block";
    } else {
      button.style.display = "none";
    }
  });
};
const scrollToTop = () => {
  button.addEventListener("click", () => {
    window.scroll({
      top: 0,
      left: 0,
      behavior: "smooth",
    });
    console.log(event);
  });
};
displayButton();
scrollToTop();
/*=====================
        01 sticky js
    ==========================*/

$(window).scroll(function () {
  if ($(this).scrollTop() > 0) {
    $("header").addClass("sticky");
  } else {
    $("header").removeClass("sticky");
  }
});

/*=====================
        landing header
    ==========================*/
$(".toggle-menu").on("click", function () {
  $(".landing-menu").toggleClass("open");
});
$(".menu-back").on("click", function () {
  $(".landing-menu").toggleClass("open");
});

new WOW().init();
})();