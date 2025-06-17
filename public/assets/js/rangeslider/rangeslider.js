(function () {
  'use strict';
  var init = function () {
    var slider2 = new rSlider({
      target: '#slider2',
      values: [0, 1, 2, 3, 4, 5, 6, '7', 8],
      range: false,
      set: [5],
      tooltip: false,
      onChange: function (vals) {
        console.log(vals);
      }
    });
    var slider3 = new rSlider({
      target: '#slider3',
      values: { min: 0, max: 100 },
      step: 10,
      range: true,
      set: [10, 40],
      scale: false,
      labels: false,
      onChange: function (vals) {
        console.log(vals);
      }
    });
    var slider = new rSlider({
      target: '#slider',
      values: [2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023],
      range: true,
      set: [2018, 2021],
      tooltip: false,
      onChange: function (vals) {
        console.log(vals);
      }
    });
    var slider4 = new rSlider({
      target: '#slider4',
      values: [100, 200, 300, 400, 500, 600, '700', 800],
      range: false,
      set: [500],
      tooltip: true,
      disabled: true,
      onChange: function (vals) {
        console.log(vals);
      }
    });
    var slider5 = new rSlider({
      target: '#slider5',
      values: [10, 20, 30, 40, 50, 60, 70, 80],
      range: true,
      set: [30, 50],
      tooltip: false,
      onChange: function (vals) {
        console.log(vals);
      }
    });
    var slider6 = new rSlider({
      target: '#slider6',
      values: [10, 20, 30, 40, 50, 60, 70, 80],
      range: true,
      set: [20, 70],
      tooltip: false,
      onChange: function (vals) {
        console.log(vals);
      }
    });
  };
  window.onload = init;
  // ============================================================
  const slider_input = document.getElementById('slider_input');
  if (slider_input !== null) {
    // Access the 'value' property only if `slider_input` is not null
    const slider_input = document.getElementById('slider_input'),
      slider_thumb = document.getElementById('slider_thumb'),
      slider_line = document.getElementById('slider_line');
    function showSliderValue() {
      slider_thumb.innerHTML = slider_input.value;
      const bulletPosition = (slider_input.value / slider_input.max),
        space = slider_input.offsetWidth - slider_thumb.offsetWidth;
      slider_thumb.style.left = (bulletPosition * space) + 'px';
      slider_line.style.width = slider_input.value + '%';
    }
    showSliderValue();
    window.addEventListener("resize", showSliderValue);
    slider_input.addEventListener('input', showSliderValue, false);
    console.log(slider_input.value);
  }
  // ====================================================================
})();