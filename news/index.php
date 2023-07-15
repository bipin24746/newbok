<?php
session_start();
if (!isset($_SESSION['email'])) {
    // Redirect the user to the login page or appropriate action
    header("Location: login.php");
    exit;
}
?>

<?php include('header.php'); ?>

<div class="dashboard-container max-w-5xl mx-auto">
    <h2 class="text-center font-semibold">Now Showing</h2>

    <div class="movies-container flex flex-wrap justify-center">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "moviebooking";
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM movie";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $mid = $row['id'];
                $name = $row['name'];
                $image = $row['image'];

                echo "
                <div class='movie-card border-2 border-gray-300 p-2 md:p-4 w-1/2 md:w-1/4 lg:w-1/5 m-2'>
                    <img src='images/$image' alt='Movie Poster' class='h-32 md:h-48 w-full object-cover'>
                    <div class='movie-details mt-2'>
                        <h5 class='movie-name text-sm md:text-base font-bold mb-1'>$name</h5>
                        <form action='booking.php' method='post'>
                            <input type='hidden' name='mid' value='$mid'>
                            <input type='hidden' name='mname' value='$name'>
                            <input type='submit' name='book_now' value='Book Now' class='book bg-green-500 px-2 py-1 text-xs md:text-sm font-semibold rounded cursor-pointer'>
                        </form>
                    </div>
                </div>";
            }
        } else {
            echo "No movies found.";
        }
        $conn->close();
        ?>
    </div>
</div>

<?php include('footer.php'); ?>
