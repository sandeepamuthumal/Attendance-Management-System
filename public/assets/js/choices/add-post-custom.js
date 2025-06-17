
document.addEventListener('DOMContentLoaded', function() {
    new Choices('#choices-remove-button', {
        allowHTML: true,
        removeItemButton: true,
      });
      var editor1 = new Quill("#editor1", {
        modules: { toolbar: "#toolbar1" },
        theme: "snow",
        placeholder: "Enter your messages...",
      });
});