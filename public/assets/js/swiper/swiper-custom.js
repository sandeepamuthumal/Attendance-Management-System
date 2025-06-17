var swiper = new Swiper(".mySwiper", {
    spaceBetween: 30,
    slidesPerView: 3,
    loop: true,
    centeredSlides: true,
    spaceBetween: 10,
    autoplay: {
      delay: 2500,
      disableOnInteraction: false,

    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
      dynamicBullets: true,
    },
    breakpoints: {
      320: {
        slidesPerView: 1,
      },
      768: {
        slidesPerView: 2,
      },
      992: {
        slidesPerView: 3,
      }
    },
  });
  // mouse-variant
  var swiper = new Swiper(".mouseSwiper", {
    slidesPerView: 3,
    spaceBetween: 10,
    loop: true,
    mousewheel: true,
    pagination: {
      el: ".mouse-pagination",
      clickable: true,
      dynamicBullets: true,
    },
    breakpoints: {
      320: {
        slidesPerView: 1,
      },
      768: {
        slidesPerView: 2,
      },
      992: {
        slidesPerView: 3,
      }
    },
  });