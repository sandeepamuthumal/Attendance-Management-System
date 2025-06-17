document.addEventListener("DOMContentLoaded", function () {
 //config
 var singleNoSearch = new Choices("#choices-single-no-search", {
  allowHTML: true,
  searchEnabled: false,
  removeItemButton: true,
  choices: [
    { value: "One", label: "Alabama" },
    { value: "Two", label: "California", disabled: true },
    { value: "Three", label: "Colorado" },
  ],
}).setChoices(
  [
    { value: "Four", label: "Indiana", disabled: true },
    { value: "Five", label: "Iowa" },
    { value: "Six", label: "Massachusetts", selected: true },
  ],
  "value",
  "label",
  false  
);
});
  //Multiple select input
  var multipleCancelButton = new Choices("#choices-multiple-remove-button", {
    allowHTML: true,
    removeItemButton: true,
  });
  // Select one inputs
  new Choices("#choices-scrolling-dropdown", {
    allowHTML: true,
    shouldSort: false,
  });
  //Multiple sections with headers
  var multipleDefault = new Choices(
    document.getElementById("choices-multiple-groups"),
    { allowHTML: true }
  );
  //Basic typeahead
  var cities = new Choices(document.getElementById("cities"), {
    allowHTML: true,
  });
  //rtl
  var rtl = new Choices(document.getElementById("rtl"), {
    allowHTML: true,
  });
// });