<?php include('header.php'); ?>

<?php
session_start();
if (!isset($_SESSION['email'])) {
    // Redirect the user to the login page or appropriate action
    header("Location: login.php");
    exit;
}
?>

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
                $description = $row['description'];
                $price = $row['price'];
                $time = $row['time'];
                $image = $row['image'];

                echo "
                <div class='movie-card border-2 border-gray-300 p-4 w-1/4 m-6'>
                    <img src='images/$image' alt='Movie Poster' class='h-48 w-full object-cover'>
                    <div class='movie-details mt-4'>
                        <h5 class='movie-name font-bold mb-2'>$name</h5>
                        <p class='movie-description mb-4'>$description</p>
                        <p class='movie-price mb-4'>Price: $price</p>
                        <p class='movie-price mb-4'>Show Time: $time</p>
                        <form action='index.php' method='post'>
                            <input type='hidden' name='time' value='$time'>
                            <input type='hidden' name='mid' value='$mid'>
                            <input type='hidden' name='mname' value='$name'>
                            <input type='submit' name='book_now' value='Book Now' class='book bg-green-500'>
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
