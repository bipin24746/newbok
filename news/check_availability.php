<?php
// Process the AJAX request to check seat availability

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "moviebooking";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedDate = $_POST['date'];
    $selectedTime = $_POST['time'];

    // Check if any seats are already reserved for the selected date and time
    $sql = "SELECT COUNT(*) AS reserved_count FROM bookings WHERE date = '$selectedDate' AND time = '$selectedTime'";
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $reservedCount = $row['reserved_count'];

        if ($reservedCount > 0) {
            // Seats are already reserved
            $response = array('available' => false);
            echo json_encode($response);
        } else {
            // Seats are available
            $response = array('available' => true);
            echo json_encode($response);
        }
    }
}

$conn->close();
?>
