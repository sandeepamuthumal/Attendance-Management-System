(function () {
  document.addEventListener("DOMContentLoaded", function () {
    /* initialize the external events
      -----------------------------------------------------------------*/

    var containerEl = document.getElementById("external-events-list");
    new FullCalendar.Draggable(containerEl, {
      itemSelector: ".fc-event",
      eventData: function (eventEl) {
        return {
          title: eventEl.innerText.trim(),
        };
      },
    });

    /* initialize the calendar
      -----------------------------------------------------------------*/

    var calendarEl = document.getElementById("calendar");
    var calendar = new FullCalendar.Calendar(calendarEl, {
      headerToolbar: {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek",
      },
      initialView: "dayGridMonth",
      initialDate: "2024-05-31",
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      selectable: true,
      nowIndicator: true,
      // dayMaxEvents: true, // allow "more" link when too many events
      events: [
        {
          title: "All Day Event",
          start: "2024-05-01",
        },
        {
          title: "Tour with our Team.",
          start: "2024-05-07",
          end: "2024-05-10",
        },
        {
          groupId: 999,
          title: "Meeting with Team",
          start: "2024-05-05T16:00:00",
        },
        {
          groupId: 999,
          title: "Upload New Project",
          start: "2024-05-16T16:00:00",
        },
        {
          title: "Birthday Party",
          start: "2024-05-24",
          end: "2024-05-26",
        },
        {
          title: "Reporting about Theme",
          start: "2024-05-28T10:30:00",
          end: "2024-05-29T12:30:00",
        },
        {
          title: "Lunch",
          start: "2024-05-30T12:00:00",
        },
        {
          title: "Meeting",
          start: "2024-05-12T14:30:00",
        },
        {
          title: "Happy Hour",
          start: "2024-05-30T17:30:00",
        },
      ],
      editable: true,
      droppable: true, // this allows things to be dropped onto the calendar
      drop: function (arg) {
        // is the "remove after drop" checkbox checked?
        if (document.getElementById("drop-remove").checked) {
          // if so, remove the element from the "Draggable Events" list
          arg.draggedEl.parentNode.removeChild(arg.draggedEl);
        }
      },
    });
    calendar.render();
  });
})();