<?php
session_start();
if( !isset($_SESSION["login"])) {
  header("Location: login.php");
  exit;
}

require "function.php";
if(isset($_GET['searchYear'])) {
  $varTahun = $_GET['year'];
 
  // current month
  $queryc = currentMonth();
  foreach($queryc as $c1){
  $qc =  $c1['total_data'];
  }
  
  // last month
  $querylm = lastMonth();
  foreach($querylm as $lm1){
    $qlm =  $lm1['last_month_energy'];
  }
  
  // energy consumption
  $bulanEnergyMonthlyConsumption = bulanEnergyMonthlyConsumptionF($varTahun);
  $dataEnergyMonthlyConsumption = dataEnergyMonthlyConsumptionF($varTahun);
}

else{
  // energy consumption
  $queryc = currentMonth();
  foreach($queryc as $c2){
    $qc =  $c2['total_data'];
  }

  // last month
  $querylm = lastMonth();
  foreach($querylm as $lm2){
    $qlm =  $lm2['last_month_energy'];
  }

  $bulanEnergyMonthlyConsumption = bulanEnergyMonthlyConsumptionN();
  $dataEnergyMonthlyConsumption = dataEnergyMonthlyConsumptionN();

  $tahunEnergyAnnualConsumption = tahunEnergyAnnualConsumptionN();
  $dataEnergyAnnualConsumption = dataEnergyAnnualConsumptionN();
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Taka Turbomachinary</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End Plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
    <!-- Apex Chart -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        // Ignore this in your implementation
        window.isMbscDemo = true;
    </script>
    <link rel="stylesheet" href="assets/css/timetable/css/mobiscroll.javascript.min.css">
    <script src="assets/js/timetable/mobiscroll.javascript.min.js"></script>

    <style type="text/css">
            body {
        margin: 0;
        padding: 0;
    }

    body,
    html {
        height: 100%;
    }

            .event-color-c {
        display: flex;
        margin: 16px;
        align-items: center;
        cursor: pointer;
    }
    
    .event-color-label {
        flex: 1 0 auto;
    }
    
    .event-color {
        width: 30px;
        height: 30px;
        border-radius: 15px;
        margin-right: 10px;
        margin-left: 240px;
        background: #5ac8fa;
    }
    
    .crud-color-row {
        display: flex;
        justify-content: center;
        margin: 5px;
    }
    
    .crud-color-c {
        padding: 3px;
        margin: 2px;
    }
    
    .crud-color {
        position: relative;
        min-width: 46px;
        min-height: 46px;
        margin: 2px;
        cursor: pointer;
        border-radius: 23px;
        background: #5ac8fa;
    }
    
    .crud-color-c.selected,
    .crud-color-c:hover {
        box-shadow: inset 0 0 0 3px #007bff;
        border-radius: 48px;
    }
    
    .crud-color:before {
        position: absolute;
        top: 50%;
        left: 50%;
        margin-top: -10px;
        margin-left: -10px;
        color: #f7f7f7;
        font-size: 20px;
        text-shadow: 0 0 3px #000;
        display: none;
    }
    
    .crud-color-c.selected .crud-color:before {
        display: block;
    }

    .mbsc-event-bg {
      background-color: grey !important;
    }

    </style>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:../../partials/_sidebar.html -->
      <?php
        if($_SESSION['username'] == 'planner'){
          include 'pages/sidebar/sidebar_planner.php'; 
        }else{
          include 'pages/sidebar/sidebar_all.php';
        } 
                
      ?>
      
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_navbar.html -->
        <?php include 'pages/navbar/navbar.php'; ?>
        
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title"> Timetable </h3>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#">Timetable</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Lathe</li>
                </ol>
              </nav>
            </div>
            <?php include 'pages/card/card.php'; ?>
            <div class="row">
              <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  <div mbsc-page class="demo-create-read-update-delete-CRUD">
                        <div style="height:100%">
                                <div id="demo-add-delete-event"></div>
                    
                    <div style="display: none">
                    <div id="demo-add-popup">
                        <div class="mbsc-form-group">
                            <label>
                                Title
                                <input mbsc-input id="event-title">
                            </label>
                            <label>
                                Description
                                <textarea mbsc-textarea id="event-desc"></textarea>
                            </label>
                        </div>
                        <div class="mbsc-form-group">
                            <label>
                                All-day
                                <input mbsc-switch id="event-all-day" type="checkbox" />
                            </label>
                            <label>
                                Starts
                                <input mbsc-input id="start-input" />
                            </label>
                            <label>
                                Ends
                                <input mbsc-input id="end-input" />
                            </label>
                            <div id="event-date"></div>
                            <div id="event-color-picker" class="event-color-c">
                                <div class="event-color-label">Color</div>
                                <div id="event-color-cont">
                                    <div id="event-color" class="event-color"></div>
                                </div>
                            </div>
                            <label>
                                Show as busy
                                <input id="event-status-busy" mbsc-segmented type="radio" name="event-status" value="busy">
                            </label>
                            <label>
                                Show as free
                                <input id="event-status-free" mbsc-segmented type="radio" name="event-status" value="free">
                            </label>
                            <div class="mbsc-button-group">
                                <button class="mbsc-button-block" id="event-delete" mbsc-button data-color="danger" data-variant="outline">Delete event</button>
                            </div>
                        </div>
                    </div>
                    
                    <div id="demo-event-color">
                        <div class="crud-color-row">
                            <div class="crud-color-c" data-value="#ffeb3c">
                                <div class="crud-color mbsc-icon mbsc-font-icon mbsc-icon-material-check" style="background:#ffeb3c"></div>
                            </div>
                            <div class="crud-color-c" data-value="#ff9900">
                                <div class="crud-color mbsc-icon mbsc-font-icon mbsc-icon-material-check" style="background:#ff9900"></div>
                            </div>
                            <div class="crud-color-c" data-value="#f44437">
                                <div class="crud-color mbsc-icon mbsc-font-icon mbsc-icon-material-check" style="background:#f44437"></div>
                            </div>
                            <div class="crud-color-c" data-value="#ea1e63">
                                <div class="crud-color mbsc-icon mbsc-font-icon mbsc-icon-material-check" style="background:#ea1e63"></div>
                            </div>
                            <div class="crud-color-c" data-value="#9c26b0">
                                <div class="crud-color mbsc-icon mbsc-font-icon mbsc-icon-material-check" style="background:#9c26b0"></div>
                            </div>
                        </div>
                        <div class="crud-color-row">
                            <div class="crud-color-c" data-value="#3f51b5">
                                <div class="crud-color mbsc-icon mbsc-font-icon mbsc-icon-material-check" style="background:#3f51b5"></div>
                            </div>
                            <div class="crud-color-c" data-value="">
                                <div class="crud-color mbsc-icon mbsc-font-icon mbsc-icon-material-check"></div>
                            </div>
                            <div class="crud-color-c" data-value="#009788">
                                <div class="crud-color mbsc-icon mbsc-font-icon mbsc-icon-material-check" style="background:#009788"></div>
                            </div>
                            <div class="crud-color-c" data-value="#4baf4f">
                                <div class="crud-color mbsc-icon mbsc-font-icon mbsc-icon-material-check" style="background:#4baf4f"></div>
                            </div>
                            <div class="crud-color-c" data-value="#7e5d4e">
                                <div class="crud-color mbsc-icon mbsc-font-icon mbsc-icon-material-check" style="background:#7e5d4e"></div>
                            </div>
                        </div>
                    </div>
                    </div>
                        </div>
                    </div>
                    
                  </div>
                </div>
              </div>  
              
            </div>
            
          </div>
          <!-- content-wrapper ends -->
          <?php include 'pages/footer/footer.php'; ?>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/vendors/chart.js/Chart.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/hoverable-collapse.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script src="assets/js/chart.js"></script>
    <!-- <script src="assets/js/chart-new.js"></script> -->
    <!-- End custom js for this page -->

    <script>
      mobiscroll.setOptions({
        locale: mobiscroll.localeEn,                                  // Specify language like: locale: mobiscroll.localePl or omit setting to use default
        theme: 'ios',                                                 // Specify theme like: theme: 'ios' or omit setting to use default
        themeVariant: 'light'                                         // More info about themeVariant: https://docs.mobiscroll.com/5-24-1/javascript/eventcalendar#opt-themeVariant
    });
    var lastEventEnd = null;
    var calendar,
        popup,
        range,
        oldEvent,
        tempEvent = {},
        deleteEvent,
        restoreEvent,
        colorPicker,
        tempColor,
        titleInput = document.getElementById('event-title'),
        descriptionTextarea = document.getElementById('event-desc'),
        allDaySwitch = document.getElementById('event-all-day'),
        freeSegmented = document.getElementById('event-status-free'),
        busySegmented = document.getElementById('event-status-busy'),
        deleteButton = document.getElementById('event-delete'),
        colorSelect = document.getElementById('event-color-picker'),
        pickedColor = document.getElementById('event-color'),
        colorElms = document.querySelectorAll('.crud-color-c'),
        datePickerResponsive = {
            medium: {
                controls: ['calendar'],
                touchUi: false
            }
        },
        datetimePickerResponsive = {
            medium: {
                controls: ['calendar', 'time'],
                touchUi: false
            }
        },
        myData = [{
            id: 1,
            start: '2023-05-08T13:00',
            end: '2023-05-08T13:45',
            title: 'Lunch @ Butcher\'s',
            description: '',
            allDay: false,
            free: true,
            color: '#009788'            
            },
            {
            id: 2,
            start: '2023-05-16T15:00',
            end: '2023-05-16T16:00',
            title: 'General ',
            description: '',
            allDay: false,
            free: false,
            color: '#ff9900'
            }
        ];
    
    

    function createAddPopup(elm) {
        // hide delete button inside add popup
        deleteButton.style.display = 'none';
    
        deleteEvent = true;
        restoreEvent = false;
        if (lastEventEnd) {
            range.setVal([lastEventEnd, null]);
        } else {
            range.setVal([null, null]);
        }
    
        // set popup header text and buttons for adding
        popup.setOptions({
            headerText: 'New event',
                                              // More info about headerText: https://docs.mobiscroll.com/5-24-1/javascript/eventcalendar#opt-headerText
            buttons: [                                                // More info about buttons: https://docs.mobiscroll.com/5-24-1/javascript/eventcalendar#opt-buttons
                'cancel',
                {
                    text: 'Add',
                    keyCode: 'enter',
                    handler: function () {
                        calendar.updateEvent(tempEvent);
                        deleteEvent = false;
                        // navigate the calendar to the correct view
                        calendar.navigateToEvent(tempEvent);
                        saveEventToLocalStorage(tempEvent);
                        popup.close();
                    },
                    cssClass: 'mbsc-popup-button-primary'
                }
            ]
        }
        );
    
        // fill popup with a new event data
        mobiscroll.getInst(titleInput).value = tempEvent.title;
        mobiscroll.getInst(descriptionTextarea).value = '';
        mobiscroll.getInst(allDaySwitch).checked = tempEvent.allDay;
        range.setVal([tempEvent.start, tempEvent.end]);
        mobiscroll.getInst(busySegmented).checked = true;
        range.setOptions({
            controls: tempEvent.allDay ? ['date'] : ['datetime'],
            responsive: tempEvent.allDay ? datePickerResponsive : datetimePickerResponsive
        });
        pickedColor.style.background = '';
    
        // set anchor for the popup
        popup.setOptions({ anchor: elm });
    
        popup.open();
    }
    
    function createEditPopup(args) {
        var ev = args.event;
    
        // show delete button inside edit popup
        deleteButton.style.display = 'block';
    
        deleteEvent = false;
        restoreEvent = true;
        if (ev.end) {
            lastEventEnd = ev.end;
        } else {
            lastEventEnd = null;
        }
    
        // set popup header text and buttons for editing
        popup.setOptions({
            headerText: 'Edit event',                                 // More info about headerText: https://docs.mobiscroll.com/5-24-1/javascript/eventcalendar#opt-headerText
            buttons: [                                                // More info about buttons: https://docs.mobiscroll.com/5-24-1/javascript/eventcalendar#opt-buttons
                'cancel',
                {
                    text: 'Save',
                    keyCode: 'enter',
                    handler: function () {
                        var date = range.getVal();
                        var eventToSave = {
                            id: ev.id,
                            title: titleInput.value,
                            description: descriptionTextarea.value,
                            allDay: mobiscroll.getInst(allDaySwitch).checked,
                            start: date[0],
                            end: date[1],
                            free: mobiscroll.getInst(freeSegmented).checked,
                            color: ev.color,
                        };
                        // update event with the new properties on save button click
                        calendar.updateEvent(eventToSave);
                        updateEventInLocalStorage(tempEvent);
                        // navigate the calendar to the correct view
                        calendar.navigateToEvent(eventToSave);
                        restoreEvent = false;
                        popup.close();
                    },
                    cssClass: 'mbsc-popup-button-primary'
                }
            ]
        });
    
        // fill popup with the selected event data
        mobiscroll.getInst(titleInput).value = ev.title || '';
        mobiscroll.getInst(descriptionTextarea).value = ev.description || '';
        mobiscroll.getInst(allDaySwitch).checked = ev.allDay || false;
        range.setVal([ev.start, ev.end]);
        pickedColor.style.background = ev.color || '';
    
        if (ev.free) {
            mobiscroll.getInst(freeSegmented).checked = true;
        } else {
            mobiscroll.getInst(busySegmented).checked = true;
        }
    
        // change range settings based on the allDay
        range.setOptions({
            controls: ev.allDay ? ['date'] : ['datetime'],
            responsive: ev.allDay ? datePickerResponsive : datetimePickerResponsive
        });
    
        // set anchor for the popup
        popup.setOptions({ anchor: args.domEvent.currentTarget });
        popup.open();
    }
    
    calendar = mobiscroll.eventcalendar('#demo-add-delete-event', {
        clickToCreate: 'double',                                      // More info about clickToCreate: https://docs.mobiscroll.com/5-24-1/javascript/eventcalendar#opt-clickToCreate
        dragToCreate: true,                                           // More info about dragToCreate: https://docs.mobiscroll.com/5-24-1/javascript/eventcalendar#opt-dragToCreate
        dragToMove: true,                                             // More info about dragToMove: https://docs.mobiscroll.com/5-24-1/javascript/eventcalendar#opt-dragToMove
        dragToResize: true,                                           // More info about dragToResize: https://docs.mobiscroll.com/5-24-1/javascript/eventcalendar#opt-dragToResize
        view: {                                                       // More info about view: https://docs.mobiscroll.com/5-24-1/javascript/eventcalendar#opt-view
            schedule: { type: 'week' }
        },
        data: myData,                                                 // More info about data: https://docs.mobiscroll.com/5-24-1/javascript/eventcalendar#opt-data
        onEventClick: function (args) {                               // More info about onEventClick: https://docs.mobiscroll.com/5-24-1/javascript/eventcalendar#event-onEventClick
            oldEvent = Object.assign({}, args.event);
            tempEvent = args.event;
    
            if (!popup.isVisible()) {
                createEditPopup(args);
            }
        },
        onEventCreated: function (args) {                             // More info about onEventCreated: https://docs.mobiscroll.com/5-24-1/javascript/eventcalendar#event-onEventCreated
            popup.close();
            // store temporary event
            tempEvent = args.event;
            createAddPopup(args.target);
        },
        onEventDeleted: function (args) {                             // More info about onEventDeleted: https://docs.mobiscroll.com/5-24-1/javascript/eventcalendar#event-onEventDeleted
            mobiscroll.snackbar({ 
                button: {
                    action: function () {
                        calendar.addEvent(args.event);
                    },
                    text: 'Undo'
                },
                message: 'Event deleted'
            });
            // Hapus event dari local storage
            deleteEventFromLocalStorage(args.event);
        }
    });
    
    popup = mobiscroll.popup('#demo-add-popup', {
        display: 'bottom',                                            // Specify display mode like: display: 'bottom' or omit setting to use default
        contentPadding: false,
        fullScreen: true,
        onClose: function () {                                        // More info about onClose: https://docs.mobiscroll.com/5-24-1/javascript/eventcalendar#event-onClose
            if (deleteEvent) {
                calendar.removeEvent(tempEvent);
            } else if (restoreEvent) {
                calendar.updateEvent(oldEvent);
            }
        },
        responsive: {                                                 // More info about responsive: https://docs.mobiscroll.com/5-24-1/javascript/eventcalendar#opt-responsive
            medium: {
                display: 'anchored',                                  // Specify display mode like: display: 'bottom' or omit setting to use default
                width: 400,                                           // More info about width: https://docs.mobiscroll.com/5-24-1/javascript/eventcalendar#opt-width
                fullScreen: false,
                touchUi: false
            }
        }
    });
    
    titleInput.addEventListener('input', function (ev) {
        // update current event's title
        tempEvent.title = ev.target.value;
    });
    
    descriptionTextarea.addEventListener('change', function (ev) {
        // update current event's title
        tempEvent.description = ev.target.value;
    });
    
    allDaySwitch.addEventListener('change', function () {
        var checked = this.checked
        // change range settings based on the allDay
        range.setOptions({
            controls: checked ? ['date'] : ['datetime'],
            responsive: checked ? datePickerResponsive : datetimePickerResponsive
        });
    
        // update current event's allDay property
        tempEvent.allDay = checked;
    });
    
    range = mobiscroll.datepicker('#event-date', {
        controls: ['date'],
        select: 'range',
        startInput: '#start-input',
        endInput: '#end-input',
        showRangeLabels: false,
        touchUi: true,
        responsive: datePickerResponsive,                             // More info about responsive: https://docs.mobiscroll.com/5-24-1/javascript/eventcalendar#opt-responsive
        onChange: function (args) {
            var date = args.value;
            // update event's start date
            tempEvent.start = date[0];
            tempEvent.end = date[1];
        }
    });
    
    document.querySelectorAll('input[name=event-status]').forEach(function (elm) {
        elm.addEventListener('change', function () {
            // update current event's free property
            tempEvent.free = mobiscroll.getInst(freeSegmented).checked;
        });
    });

    deleteButton.addEventListener('click', function () {
        // delete current event on button click
        calendar.removeEvent(tempEvent);
        popup.close();
    
        // save a local reference to the deleted event
        var deletedEvent = tempEvent;
    
        mobiscroll.snackbar({ 
            button: {
                action: function () {
                    calendar.addEvent(deletedEvent);
                },
                text: 'Undo'
            },
            message: 'Event deleted'
        });
    });
    
    colorPicker = mobiscroll.popup('#demo-event-color', {
        display: 'bottom',                                            // Specify display mode like: display: 'bottom' or omit setting to use default
        contentPadding: false,
        showArrow: false,
        showOverlay: false,
        buttons: [
            'cancel',
            {
                text: 'Set',
                keyCode: 'enter',
                handler: function (ev) {
                    setSelectedColor();
                },
                cssClass: 'mbsc-popup-button-primary'
            }
        ],
        responsive: {                                                 // More info about responsive: https://docs.mobiscroll.com/5-24-1/javascript/eventcalendar#opt-responsive
            medium: {
                display: 'anchored',                                  // Specify display mode like: display: 'bottom' or omit setting to use default
                anchor: document.getElementById('event-color-cont'),  // More info about anchor: https://docs.mobiscroll.com/5-24-1/javascript/eventcalendar#opt-anchor
                buttons: [],                                          // More info about buttons: https://docs.mobiscroll.com/5-24-1/javascript/eventcalendar#opt-buttons
            }
        }
    });
    
    function selectColor(color, setColor) {
        var selectedElm = document.querySelector('.crud-color-c.selected');
        var newSelected = document.querySelector('.crud-color-c[data-value="' + color + '"]');
    
        if (selectedElm) {
            selectedElm.classList.remove('selected')
        }
        if (newSelected) {
            newSelected.classList.add('selected')
        }
        if (setColor) {
            pickedColor.style.background = color || '';
        }
    }

    function saveEventToLocalStorage(event) {
    var events = getEventsFromLocalStorage() || [];
    events.push(event);
    localStorage.setItem('events', JSON.stringify(events));
}

function updateEventInLocalStorage(event) {
    var events = getEventsFromLocalStorage() || [];
    var index = events.findIndex(function (item) {
        return item.id === event.id;
    });
    if (index !== -1) {
        events[index] = event;
        localStorage.setItem('events', JSON.stringify(events));
    }
}

function getEventsFromLocalStorage() {
    var eventsJson = localStorage.getItem('events');
    return JSON.parse(eventsJson);
}

function deleteEventFromLocalStorage(event) {
    var events = getEventsFromLocalStorage() || [];
    var index = events.findIndex(function (item) {
        return item.id === event.id;
    });
    if (index !== -1) {
        events.splice(index, 1);
        localStorage.setItem('events', JSON.stringify(events));
    }
}


    
    function setSelectedColor() {
        tempEvent.color = tempColor;
        pickedColor.style.background = tempColor;
        colorPicker.close();
    }
    
    colorSelect.addEventListener('click', function () {
        selectColor(tempEvent.color || '');
        colorPicker.open();
    });
    
    colorElms.forEach(function (elm) {
        elm.addEventListener('click', function () {
            tempColor = elm.getAttribute('data-value');
            selectColor(tempColor);
    
            if (!colorPicker.s.buttons.length) {
                setSelectedColor();
            }
        });
    });

    </script>

  </body>
</html>