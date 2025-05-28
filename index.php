<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fishbook";

// Maak verbinding
$conn = new mysqli($servername, $username, $password, $dbname);

// Controleer verbinding
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, name, weight, photo_link FROM fish_ranking ORDER BY weight DESC LIMIT 20";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fishbook</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    #modal-image {
      width: 80%;
      max-width: 400px;
      display: block;
      margin: auto;
    }
    .slider {
      position: relative;
      width: 100%;
    }
    .slider img {
      width: 100%;
      height: auto;
    }
    .hero {
      position: relative;
      width: 100%;
      max-width: 800px;
      margin: auto;
    }
    .hero img {
      width: 800px;
      height: 400px;
      opacity: 0;
      position: absolute;
      top: 0;
      left: 0;
      transition: opacity 1s ease-in-out;
    }
    .hero img.active {
      opacity: 1;
      position: relative;
    }
  </style>
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


  <!-- Modal -->
  <div id="myModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <div class="slider">
        <img id="modal-image" src="" alt="Fish Image">
      </div>
    </div>
  </div>

  <main class="content">
    <section class="ranking">
      <h2>Ranglijst</h2>
      <h3>Grootste Vis</h3>
      <ul>
        <?php
        if ($result->num_rows > 0) {
          $rank = 1;
          while($row = $result->fetch_assoc()) {
            echo "<li>$rank. " . htmlspecialchars($row["name"]) . " - " . htmlspecialchars($row["weight"]) . " kg <a href='#' class='open-modal' data-id='" . htmlspecialchars($row["id"]) . "'>(Zie Foto)</a></li>";
            $rank++;
          }
        } else {
          echo "<li>Geen records gevonden.</li>";
        }
        ?>
      </ul>
    </section>

    <section class="hero">
      <h1>Fishbook</h1>
      <div class="hero-slider">
        <img src="hero1.jpg" alt="Hero Image 1" class="active">
      </div>
    </section>
  </main>

  <a href="add_fish.php"><button class="add-button">+</button></a>

  <script>
    var modal = document.getElementById("myModal");
    var modalImg = document.getElementById("modal-image");
    var modalLinks = document.querySelectorAll(".open-modal");
    var closeBtn = document.getElementsByClassName("close")[0];

    var currentImageIndex = 0;
    var totalImages = 5;
    var imageInterval;

    modalLinks.forEach(function(link) {
      link.addEventListener("click", function(e) {
        e.preventDefault();
        var fishId = this.getAttribute("data-id");
        currentImageIndex = 0;

        function showNextImage() {
          modalImg.src = "get_image.php?id=" + fishId + "&img=" + currentImageIndex;
          currentImageIndex = (currentImageIndex + 1) % totalImages;
        }

        showNextImage();
        imageInterval = setInterval(showNextImage, 3000);

        modal.style.display = "block";
      });
    });

    closeBtn.onclick = function() {
      clearInterval(imageInterval);
      modal.style.display = "none";
    }

    window.onclick = function(event) {
      if (event.target == modal) {
        clearInterval(imageInterval);
        modal.style.display = "none";
      }
    }

    // Hero image slideshow with fade effect
    var heroImages = document.querySelectorAll(".hero-slider img");
    var heroIndex = 0;

    function cycleHeroImages() {
      heroImages.forEach(function(img, index) {
        img.classList.remove("active");
      });
      heroImages[heroIndex].classList.add("active");
      heroIndex = (heroIndex + 1) % heroImages.length;
    }

    setInterval(cycleHeroImages, 5000);
  </script>

</body>
</html>
