<?php
session_start(); // Start a session to track the logged-in user

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Validate form data
    if (empty($username) || empty($password)) {
        echo "Both fields are required!";
        exit;
    }

    // Placeholder: Check user data against the stored data in 'users.txt'
    $userFound = false;
    if (file_exists('users.txt')) {
        $users = file('users.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($users as $user) {
            // Extract stored username and hashed password
            list($storedUsername, $storedEmail, $storedHashedPassword) = explode(", ", $user);

            // Remove labels for comparison
            $storedUsername = str_replace("Username: ", "", $storedUsername);
            $storedHashedPassword = str_replace("Password: ", "", $storedHashedPassword);

            // Check if the username matches and verify the password
            if ($storedUsername === $username && password_verify($password, $storedHashedPassword)) {
                $userFound = true;
                $_SESSION['username'] = $username; // Store username in session
                break;
            }
        }
    }

    // Handle login result
    if ($userFound) {
        header("Location: index.php"); // Redirect to the homepage after login
        exit;
    } else {
        echo "Invalid username or password.";
    }
} else {
    // Redirect if the page is accessed without submitting the form
    header("Location: login.php");
    exit;
}
?>
