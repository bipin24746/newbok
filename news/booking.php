<?php include('header.php'); ?>

<style>
  .movie-container {
    display: flex;
    justify-content: center;
    align-items: center;
    flex-wrap: wrap;
    margin-top: 50px;
  }

  .movie-card {
    display: flex;
    background-color: #f2f2f2;
    border-radius: 8px;
    margin: 20px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  }

  .movie-card img {
    width: 300px;
    height: 300px;
    object-fit: cover;
    border-radius: 8px 0 0 8px;
  }

  .movie-details {
    padding: 20px;
  }

  .movie-name {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 10px;
  }

  .movie-details p {
    margin-bottom: 8px;
  }

  .movie-details span {
    font-weight: bold;
  }

  .booking-form {
    margin-top: 50px;
  }

  .booking-form h2 {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
  }

  .booking-form label {
    display: block;
    margin-bottom: 10px;
  }

  .booking-form input[type="date"] {
    padding: 8px;
    width: 100%;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }

  .booking-form select {
    padding: 8px;
    width: 100%;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }

  .booking-form button {
    padding: 8px 16px;
    background-color: #4caf50;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }
</style>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moviebooking";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$mid = isset($_POST['mid']) ? $_POST['mid'] : null;
if ($mid === null) {
    echo "Movie ID not provided.";
    exit;
}

$sql = "SELECT * FROM movie WHERE id = $mid";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $genre = $row['genre'];
        $industry = $row['industry'];
        $language = $row['language'];
        $duration = $row['duration'];
        $reldate = $row['reldate'];
        $director = $row['director'];
        $actor = $row['actor'];
        $image = $row['image'];
        $fdate = $row['fdate'];
        $sdate = $row['sdate'];
        $fshow = $row['fshow'];
        $sshow = $row['sshow'];
        $tshow = $row['tshow'];

        echo "
        <div class='movie-card'>
            <img src='images/$image' alt='Movie Poster'>
            <div class='movie-details'>
                <h1 class='movie-name'>$name</h1>
                <p><span>Genre:</span> $genre</p>
                <p><span>Industry:</span> $industry</p>
                <p><span>Language:</span> $language</p>
                <p><span>Duration:</span> $duration</p>
                <p><span>Release Date:</span> $reldate</p>
                <p><span>Director:</span> $director</p>
                <p><span>Actor:</span> $actor</p>
            </div>
        </div>";
    }
} else {
    echo "Movie not found.";
}

$conn->close();
?>

<div class="booking-form">
    <h2>Select Date and Time</h2>

    <?php
if (isset($_SESSION['updatedMovieId']) && isset($_SESSION['updatedMovieName']) && isset($_SESSION['updatedShowtime'])) {
    $updatedMovieId = $_SESSION['updatedMovieId'];
    $updatedMovieName = $_SESSION['updatedMovieName'];
    $updatedShowtime = $_SESSION['updatedShowtime'];

    // Display the updated movie and showtime as selected options
    echo "<option value='$updatedShowtime' selected>$updatedShowtime ($updatedMovieName)</option>";
} else {
    $conn2 = new mysqli($servername, $username, $password, $dbname); // New database connection

    // Fetch the showtimes from the database for the selected movie
    $sql2 = "SELECT fdate, sdate, fshow, sshow, tshow FROM movie WHERE id = $mid";
    $result2 = $conn2->query($sql2);

    if ($result2 && $result2->num_rows > 0) {
        echo "<label for='showdate' class='block mb-2 text-sm'>Select Show Date:</label>";
        echo "<select name='showdate' id='showdate' required class='block w-full border border-gray-300 rounded py-2 px-3 mb-4 focus:outline-none focus:ring focus:border-blue-500 text-sm'>";

        while ($row2 = $result2->fetch_assoc()) {
            $fdate = $row2['fdate'];
            $sdate = $row2['sdate'];

            echo "<option value='$fdate'>$fdate</option>";
            echo "<option value='$sdate'>$sdate</option>";
        }

        echo "</select>";
    }

    // Fetch the showtimes from the database for the selected movie
    $sql3 = "SELECT fdate, sdate, fshow, sshow, tshow FROM movie WHERE id = $mid";
    $result3 = $conn2->query($sql3);

    if ($result3 && $result3->num_rows > 0) {
        echo "<label for='showtime' class='block mb-2 text-sm'>Select Showtime:</label>";
        echo "<select name='showtime' id='showtime' required class='block w-full border border-gray-300 rounded py-2 px-3 focus:outline-none focus:ring focus:border-blue-500 text-sm'>";

        while ($row3 = $result3->fetch_assoc()) {
            $fshow = $row3['fshow'];
            $sshow = $row3['sshow'];
            $tshow = $row3['tshow'];

            echo "<option value='$fshow'>$fshow</option>";
            echo "<option value='$sshow'>$sshow</option>";
            echo "<option value='$tshow'>$tshow</option>";
        }

        echo "</select>";
    }

    $conn2->close(); // Close the second database connection
}
?>

<button type="submit" onclick="location.href='bookticket.php'">Book Now</button>

    </form>
</div>

<?php 
include('footer.php'); 
?>
