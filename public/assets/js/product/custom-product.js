var swiper = new Swiper('.swiper-container', {
    slidesPerView: 1,
    spaceBetween: 10,
    loop: true,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
  }); 
  document.querySelectorAll(".filter-toggle").forEach(function(element) {
    element.addEventListener("click", function() {
      document.querySelectorAll(".product-sidebar").forEach(function(sidebar) {
        sidebar.classList.toggle("open");
      });
    });
  });