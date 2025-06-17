document.addEventListener("DOMContentLoaded", function() {
    var showHideElements = document.querySelectorAll(".show-hide");
    var passwordInput = document.querySelector('#password');
    var showHideSpan = document.querySelector(".show-hide span");
    var submitButton = document.querySelector('form button[type="submit"]');

    showHideElements.forEach(function(element) {
        element.style.display = "block";
    });

    showHideSpan.classList.add("show");

    showHideSpan.addEventListener("click", function() {
        if (showHideSpan.classList.contains("show")) {
            passwordInput.setAttribute("type", "text");
            showHideSpan.classList.remove("show");
        } else {
            passwordInput.setAttribute("type", "password");
            showHideSpan.classList.add("show");
        }
    });

    submitButton.addEventListener("click", function() {
        showHideSpan.classList.add("show");
        passwordInput.setAttribute("type", "password");
    });
});