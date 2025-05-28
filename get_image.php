<?php
// get_image.php

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Database connection
    $conn = new mysqli("localhost", "root", "", "fishbook");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare the SQL query to fetch the image
    $stmt = $conn->prepare("SELECT photo_link FROM fish_ranking WHERE id = ?");
    $stmt->bind_param("i", $id); // Use an integer parameter for the image ID
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($photo_data);

    if ($stmt->fetch()) {
        header("Content-Type: image/jpeg"); // Set the appropriate content type
        echo $photo_data; // Output the binary data
    } else {
        echo "Image not found.";
    }

    $stmt->close();
    $conn->close();
}
?>
