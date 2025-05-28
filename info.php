<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Info / Contact</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    body {
      color: black;
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

  <main>
    <h2>Over Fishbook</h2>
    <p>Fishbook is een platform voor visliefhebbers waar je je vangsten kunt delen en ranglijsten kunt bekijken.</p>
    <h3>Contact</h3>
    <p>Email: support@fishbook.example</p>
  </main>
</body>
</html>
