<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Log in / Registreer</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    h2 {
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

  <h2>Log in</h2>
  <form method="POST" action="login_action.php">
    <label for="username">Gebruikersnaam:</label>
    <input type="text" id="username" name="username" required>

    <label for="password">Wachtwoord:</label>
    <input type="password" id="password" name="password" required>
    
    <input type="submit" value="Log in">
  </form>

  <h2>Registreer</h2>
  <form method="POST" action="register_action.php">
    <label for="reg_username">Gebruikersnaam:</label>
    <input type="text" id="reg_username" name="reg_username" required>

    <label for="reg_email">Email:</label>
    <input type="email" id="reg_email" name="reg_email" required>

    <label for="reg_password">Wachtwoord:</label>
    <input type="password" id="reg_password" name="reg_password" required>
    
    <input type="submit" value="Registreer">
  </form>
</body>
</html>
