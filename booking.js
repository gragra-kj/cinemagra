const container = document.querySelector('.screencontainer');
const seat = document.querySelector('.rows .seats:not(.sold)');
const count = document.getElementById("count");
const total = document.getElementById("total");
const scheduleselect = document.getElementById('cost');
let price = +scheduleselect.value;


function setScheduledata(scheduleIndex, schedulePrice) {
    localStorage.setItem('selectedScheduleIndex', scheduleIndex);
    localStorage.setItem('selectedchedulePrice', schedulePrice);

}

function updateselectedCount() {
    const selectedSeats = document.querySelectorAll('.rows .seats.selected');
    let seatsIndex = [...selectedSeats].map(function (seats) {
        return seats.getAttribute("class");
    });
    const seatNames = Array.from(selectedSeats).map(function (seat) {
        return seat.value;
    });
    localStorage.setItem('selectedSeats', JSON.stringify(seatNames));
    fetch('booking.php', {
        method: 'POST',
        body: new URLSearchParams({
            seats: seatNames.join(',')
        })
    })
        .then(response => {
            // Handle the response from the PHP script if needed
        });
    seatsIndex.shift();
    localStorage.setItem('selectedSeats', JSON.stringify(seatsIndex));
    const selectedSeatsCount = selectedSeats.length;
    count.innerText = selectedSeatsCount;
    const totalcost = selectedSeatsCount * price;
    total.innerText = totalcost;
    document.getElementById('hidden-total-cost').value = totalcost;
    setScheduledata(scheduleselect.selectedIndex, scheduleselect.value);
    const soldSeats = document.querySelectorAll('.rows .seats.sold');
    soldSeats.forEach(seat => {
        seat.classList.remove('selected');
        seat.disabled = true;
    });

}

scheduleselect.addEventListener('change',
    e => {
        schedulePrice = +e.target.value;
        setScheduledata(e.target.selectedIndex, e.target.value);
        updateselectedCount();

    })
container.addEventListener('click',
    e => {
        if (e.target.classList.contains('seats') && !e.target.classList.contains('sold')) {
            e.target.classList.toggle('selected');
            updateselectedCount();


        }
    })

$(document).ready(function () {

    $("#inputGroupSelectMovie").change(function () { //when the change event happens to the movie selection replace all the other fields

        var movieName = $("#inputGroupSelectMovie").val(); //get movie value
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "http://localhost/cinema-booking/requests/selectRoom.php?movie=" + movieName, false);
        xmlhttp.send();
        $("#inputGroupSelectRoom").html(xmlhttp.responseText); //set room values on the room field

        var roomName = $("#inputGroupSelectRoom").val(); //get room value
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "http://localhost/cinema-booking/requests/selectDate.php?movie=" + movieName + "&room=" + roomName, false);
        xmlhttp.send();
        $("#inputGroupSelectDate").html(xmlhttp.responseText); //set date values on date field

        var scheduleDate = $("#inputGroupSelectDate").val(); //get date value
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "http://localhost/cinema-booking/requests/selectTime.php?movie=" + movieName + "&room=" + roomName + "&date=" + scheduleDate, false);
        xmlhttp.send();
        $("#inputGroupSelectTime").html(xmlhttp.responseText); //set time values on time field

        var scheduleTime = $("#inputGroupSelectTime").val(); //get time value
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "http://localhost/cinema-booking/requests/selectSeats.php?room=" + roomName + "&date=" + scheduleDate + "&time=" + scheduleTime, false);
        xmlhttp.send();
        $("#createSeats").html(xmlhttp.responseText); //create seats

    });

    $("#inputGroupSelectRoom").change(function () { //if room value is changed

        var movieName = $("#inputGroupSelectMovie").val(); //get movie value

        var roomName = $("#inputGroupSelectRoom").val(); //get this value
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "http://localhost/cinema-booking/requests/selectDate.php?movie=" + movieName + "&room=" + roomName, false);
        xmlhttp.send();
        $("#inputGroupSelectDate").html(xmlhttp.responseText); //set the new date value on value field

        var scheduleDate = $("#inputGroupSelectDate").val(); //get the changed date value
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "http://localhost/cinema-booking/requests/selectTime.php?movie=" + movieName + "&room=" + roomName + "&date=" + scheduleDate, false);
        xmlhttp.send();
        $("#inputGroupSelectTime").html(xmlhttp.responseText); //set time values on time field

        var scheduleTime = $("#inputGroupSelectTime").val(); //get time value
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "http://localhost/cinema-booking/requests/selectSeats.php?room=" + roomName + "&date=" + scheduleDate + "&time=" + scheduleTime, false);
        xmlhttp.send();
        $("#createSeats").html(xmlhttp.responseText); //create seats

    });

    $("#inputGroupSelectDate").change(function () { //if date value is changed

        var movieName = $("#inputGroupSelectMovie").val(); //get movie value
        var roomName = $("#inputGroupSelectRoom").val(); //get this value

        var scheduleDate = $("#inputGroupSelectDate").val(); //get this value
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "http://localhost/cinema-booking/requests/selectTime.php?movie=" + movieName + "&room=" + roomName + "&date=" + scheduleDate, false);
        xmlhttp.send();
        $("#inputGroupSelectTime").html(xmlhttp.responseText); //set new time value on value field

        var scheduleTime = $("#inputGroupSelectTime").val(); //get time value
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "http://localhost/cinema-booking/requests/selectSeats.php?movie=" + movieName + "&room=" + roomName + "&date=" + scheduleDate + "&time=" + scheduleTime, false);
        xmlhttp.send();
        $("#createSeats").html(xmlhttp.responseText); //create seats

    });

    $("#inputGroupSelectTime").change(function () { //if time value is changed

        var roomName = $("#inputGroupSelectRoom").val(); //get this value
        var scheduleDate = $("#inputGroupSelectDate").val(); //get this value

        var scheduleTime = $("#inputGroupSelectTime").val(); //get time value
        xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET", "http://localhost/cinema-booking/requests/selectSeats.php?room=" + roomName + "&date=" + scheduleDate + "&time=" + scheduleTime, false);
        xmlhttp.send();
        $("#createSeats").html(xmlhttp.responseText); //create seats

    });



    $("#inputGroupSelectMovie option").each(function () { //check default selected values after pressing book now button or edit
        if (this.selected) {

            var roomName = $("#inputGroupSelectRoom").val(); //get room value
            var scheduleDate = $("#inputGroupSelectDate").val(); //get date value
            var scheduleTime = $("#inputGroupSelectTime").val(); //get time value
            xmlhttp = new XMLHttpRequest();
            xmlhttp.open("GET", "http://localhost/cinema-booking/requests/selectSeats.php?room=" + roomName + "&date=" + scheduleDate + "&time=" + scheduleTime, false);
            xmlhttp.send();
            $("#createSeats").html(xmlhttp.responseText); //create seats

        }

    });


});