document.addEventListener('DOMContentLoaded', function() {
  // Get the elements
  var gridLayoutView = document.querySelector('.grid-layout-view');
  var listLayoutView = document.querySelector('.list-layout-view');
  var product2LayoutView = document.querySelector('.product-2-layout-view');
  var product3LayoutView = document.querySelector('.product-3-layout-view');
  var product4LayoutView = document.querySelector('.product-4-layout-view');
  var product6LayoutView = document.querySelector('.product-6-layout-view');
  var productWrapperGrid = document.querySelector('.product-wrapper-grid');
  var leftFilter = document.querySelector('.left-filter');
  var listRow = document.querySelector('.list-collection'); 

  // List layout view
  gridLayoutView.addEventListener('click', function(e) {
    productWrapperGrid.classList.remove('list-view');
    var listChildren = listRow.children;
    for (var i = 0; i < listChildren.length; i++) {
      listChildren[i].classList.remove('col-xl-12');
    }
  });

  // Grid layout view
  listLayoutView.addEventListener('click', function(e) {
    productWrapperGrid.style.opacity = '0';
    productWrapperGrid.classList.add('list-view');
    var listChildren = listRow.children;
    for (var i = 0; i < listChildren.length; i++) {
      listChildren[i].classList.add('col-xl-12');
    }
    setTimeout(function() {
      productWrapperGrid.style.opacity = '1';
    }, 500);
  });

  // Grid options
  product2LayoutView.addEventListener('click', function(e) {
    if (productWrapperGrid.classList.contains('list-view')) {}
    else {
      var listChildren = listRow.children;
      for (var i = 0; i < listChildren.length; i++) {
        listChildren[i].className = "";
        listChildren[i].classList.add('col-sm-6');
      }
      leftFilter.classList.remove('filter-sidebar');
      leftFilter.classList.remove('custom-scrollbar');
    }
    });
  product3LayoutView.addEventListener('click', function(e) {
    if (productWrapperGrid.classList.contains('list-view')) {}
    else{
      var listChildren = listRow.children;
      for (var i = 0; i < listChildren.length; i++) {
        listChildren[i].className = "";
        listChildren[i].classList.add('col-md-4');
      }
      leftFilter.classList.remove('filter-sidebar');
      leftFilter.classList.remove('custom-scrollbar');
    }
  });

  product4LayoutView.addEventListener('click', function(e) {
    if (productWrapperGrid.classList.contains('list-view')) {}
    else{
      var listChildren = listRow.children;
      for (var i = 0; i < listChildren.length; i++) {
        listChildren[i].className = "";
        listChildren[i].classList.add('col-xl-3');
        listChildren[i].classList.add('col-sm-3');
      }
      leftFilter.classList.remove('filter-sidebar');
      leftFilter.classList.remove('custom-scrollbar');
    }
  });

  product6LayoutView.addEventListener('click', function(e) {
    if (productWrapperGrid.classList.contains('list-view')) {}
    else{
      var listChildren = listRow.children;
      for (var i = 0; i < listChildren.length; i++) {
        listChildren[i].className = "";
        listChildren[i].classList.add('col-xl-2');
      }
      leftFilter.classList.add('filter-sidebar');
      leftFilter.classList.add('custom-scrollbar');
    }
  });
});


// filter js 
  document.querySelectorAll(".md-sidebar .md-sidebar-toggle").forEach(function(element) {
    element.addEventListener("click", function(e) {
      document.querySelector(".md-sidebar .md-sidebar-aside").classList.toggle("open");
    });
});