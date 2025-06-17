const alertPlaceholder = document.getElementById("liveAlertPlaceholder");

const customAlert = (message, type) => {
  if (alertPlaceholder) {
    const wrapper = document.createElement("div");
    wrapper.innerHTML = [
      `<div class="alert alert-${type} alert-dismissible" role="alert">`,
      `   <div>${message}</div>`,
      '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
      "</div>",
    ].join("");

    alertPlaceholder.append(wrapper);
  } else {
    console.error("Element with ID 'liveAlertPlaceholder' not found.");
  }
};

document.getElementById('liveAlertBtn').addEventListener('click', () => {
  customAlert('This is a test alert!', 'success');
});