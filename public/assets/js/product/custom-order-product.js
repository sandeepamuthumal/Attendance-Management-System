document.querySelectorAll(".prooduct-details-box .close").forEach(function (element) {
    element.addEventListener("click", function (e) {
      var tets = this.parentNode.parentNode.parentNode.parentNode.classList.add("d-none");
      console.log(tets);
    });
  });
  