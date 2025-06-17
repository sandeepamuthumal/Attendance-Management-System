// swiper-custom-js
var sliderThumbnail = new Swiper('.slider-thumbnail', {
    slidesPerView: 4,
    freeMode: true,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
  });
  
  var slider = new Swiper('.slider2', {
    thumbs: {
      swiper: sliderThumbnail
    },
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
      },
  });