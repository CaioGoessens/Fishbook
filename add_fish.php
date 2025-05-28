<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $weight = $_POST["weight"];

  // Check if a file was uploaded
  if (isset($_FILES['photo_link']) && $_FILES['photo_link']['error'] == 0) {
    // Get file content
    $photo_data = file_get_contents($_FILES['photo_link']['tmp_name']);
    
    // Database connection
    $conn = new mysqli("localhost", "root", "", "fishbook");
    
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL query
    $stmt = $conn->prepare("INSERT INTO fish_ranking (name, weight, photo_link) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $name, $weight, $photo_data);  // Bind the binary image data

    // Execute the query
    if ($stmt->execute()) {
      echo "New fish added!";
    } else {
      echo "Error: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
  } else {
    echo "No valid file uploaded.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Fish</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<header class="navbar">
    <div class="nav-left">
      <a href="index.php" class="nav-item active">Home</a>
      <a href="info.php" class="nav-item">Info / Contact</a>
    </div>
    <div class="nav-right">
      <?php
      session_start(); // Start the session to check login status
      if (isset($_SESSION['username'])): ?>
        <span class="nav-item">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
        <a href="logout.php" class="nav-item">Log out</a>
      <?php else: ?>
        <a href="login.php" class="nav-item">Log in / Registreer</a>
      <?php endif; ?>
    </div>
</header>

  <h2>Add a Fish</h2>
  <form method="POST" action="add_fish.php" enctype="multipart/form-data">
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" required><br><br>
    <label for="weight">Weight (kg):</label><br>
    <input type="number" id="weight" name="weight" step="0.01" required><br><br>
    <label for="photo_link">Photo:</label><br>
    <input type="file" id="photo_link" name="photo_link" required><br><br>
    <input type="submit" value="Add Fish">
  </form>
</body>
</html>
