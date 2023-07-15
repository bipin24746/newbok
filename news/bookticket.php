<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Movie Seat Booking</title>
  <style>
    @import url("https://fonts.googleapis.com/css?family=Lato&display=swap");

* {
  box-sizing: border-box;
}

body {
  background-color: #f4f4f4;
  color: #333;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100vh;
  font-family: "Lato", sans-serif;
  margin: 0;
}

.movie-container {
  margin: 20px 0;
}

.movie-container select {
  background-color: #fff;
  border: 0;
  border-radius: 5px;
  font-size: 16px;
  padding: 5px 15px;
  -moz-appearance: none;
  -webkit-appearance: none;
  appearance: none;
}

.container {
  perspective: 1000px;
  margin-bottom: 30px;
}

.seat {
  background-color: #cfd8dc;
  height: 30px;
  width: 30px;
  margin: 5px;
  border-radius: 5px;
  transition: background-color 0.2s ease-in-out;
  display: flex;
  justify-content: center;
  align-items: center;
  cursor: pointer;
}

.seat.selected {
  background-color: #64b5f6;
}

.seat.reserved {
  background-color: red;
}

.seat.sold {
  background-color: #bdbdbd;
  cursor: not-allowed;
}

.seat:not(.sold):hover {
  cursor: pointer;
  transform: scale(1.05);
}

.showcase {
  background: rgba(0, 0, 0, 0.1);
  padding: 5px 10px;
  border-radius: 5px;
  color: #777;
  list-style-type: none;
  display: flex;
  justify-content: space-between;
}

.showcase li {
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 10px;
}

.showcase li small {
  margin-left: 5px;
  font-size: 14px;
}

.row {
  display: flex;
  justify-content: center;
}

.screen {
  background-color: #e0e0e0;
  height: 100px;
  width: 100%;
  margin: 15px 0;
  transform: rotateX(-48deg);
  box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
}

.text {
  margin: 10px 0;
  font-size: 16px;
  font-weight: bold;
}

.text span {
  color: #2196f3;
}

button {
  background-color: #2196f3;
  color: #fff;
  border: 0;
  border-radius: 5px;
  padding: 10px 15px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease-in-out;
}

button:hover {
  background-color: #1976d2;
}

button:disabled {
  background-color: #bdbdbd;
  cursor: not-allowed;
}

  </style>
</head>
<body>
  <div id="movie">
  
  </div>
  <ul class="showcase">
    <li>
      <div class="seat"></div>
      <small>Available</small>
    </li>
    <li>
      <div class="seat selected"></div>
      <small>Selected</small>
    </li>
    <li>
      <div class="seat reserved"></div>
      <small>Reserved</small>
    </li>
  </ul>
  <div class="container">
    <div class="screen"></div>

    <div class="row">
      <div class="seat" value="1">1</div>
      <div class="seat" value="2">2</div>
      <div class="seat" value="3">3</div>
      <div class="seat" value="4">4</div>
      <div class="seat" value="5">5</div>
      <div class="seat" value="6">6</div>
      <div class="seat" value="7">7</div>
      <div class="seat" value="8">8</div>
    </div>

    <div class="row">
      <div class="seat" value="9">9</div>
      <div class="seat" value="10">10</div>
      <div class="seat" value="11">11</div>
      <div class="seat" value="12">12</div>
      <div class="seat" value="13">13</div>
      <div class="seat" value="14">14</div>
      <div class="seat" value="15">15</div>
      <div class="seat" value="16">16</div>
    </div>
  </div>

  <p class="text">
    You have selected <span id="count">0</span> seat for a price of RS.
    <span id="total">0</span>
  </p>
  <button id="okButton">OK</button>
</body>
<script type="text/javascript">
    const seats = document.querySelectorAll('.row .seat');
const count = document.getElementById('count');
const total = document.getElementById('total');
const movieSelect = document.getElementById('movie');
const okButton = document.getElementById('okButton');

let ticketPrice = +movieSelect.value;
let selectedSeats = [];

function updateSelectedCount() {
  const selectedSeatsCount = selectedSeats.length;
  count.innerText = selectedSeatsCount;
  total.innerText = selectedSeatsCount * ticketPrice;
}

function selectSeat() {
  if (!this.classList.contains('reserved')) {
    this.classList.toggle('selected');
    const seatIndex = [...seats].indexOf(this);
    if (selectedSeats.includes(seatIndex)) {
      selectedSeats = selectedSeats.filter(seat => seat !== seatIndex);
    } else {
      selectedSeats.push(seatIndex);
    }
    updateSelectedCount();
  }
}

seats.forEach(seat => {
  seat.addEventListener('click', selectSeat);
});

okButton.addEventListener('click', () => {
  selectedSeats.forEach(seatIndex => {
    seats[seatIndex].classList.remove('selected');
    seats[seatIndex].classList.add('reserved');
  });
  selectedSeats = [];
  updateSelectedCount();
});

</script>
</html>
