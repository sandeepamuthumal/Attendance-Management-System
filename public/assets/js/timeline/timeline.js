function hideBlocks(blocks, offset) {
  blocks.forEach(function(block) {
    if (block.getBoundingClientRect().top > (window.innerHeight || document.documentElement.clientHeight) * offset) {
      block.querySelector('.cd-timeline-img').classList.add('is-hidden');
      block.querySelector('.cd-timeline-content').classList.add('is-hidden');
    }
  });
}

function showBlocks(blocks, offset) {
  blocks.forEach(function(block) {
    if (block.getBoundingClientRect().top <= (window.innerHeight || document.documentElement.clientHeight) * offset && block.querySelector('.cd-timeline-img').classList.contains('is-hidden')) {
      block.querySelector('.cd-timeline-img').classList.remove('is-hidden');
      block.querySelector('.cd-timeline-content').classList.remove('is-hidden');
      block.querySelector('.cd-timeline-img').classList.add('bounce-in');
      block.querySelector('.cd-timeline-content').classList.add('bounce-in');
    }
  });
}

// Example usage:
var timelineBlocks = document.querySelectorAll('.cd-timeline-block');
var offset = 0.8;
hideBlocks(timelineBlocks, offset);

window.addEventListener('scroll', function() {
  (!window.requestAnimationFrame)
    ? setTimeout(function() { showBlocks(timelineBlocks, offset); }, 100)
    : window.requestAnimationFrame(function() { showBlocks(timelineBlocks, offset); });
});