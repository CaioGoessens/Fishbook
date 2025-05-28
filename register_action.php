<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $username = htmlspecialchars($_POST['reg_username']);
    $email = htmlspecialchars($_POST['reg_email']);
    $password = htmlspecialchars($_POST['reg_password']);

    // Validate form data (basic example)
    if (empty($username) || empty($email) || empty($password)) {
        echo "All fields are required!";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!";
        exit;
    }

    // Placeholder: Hash the password (you should store hashed passwords for security)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Placeholder: Save user data to a database (or a file for testing purposes)
    // Example: Write data to a file
    $userData = "Username: $username, Email: $email, Password: $hashedPassword\n";
    file_put_contents('users.txt', $userData, FILE_APPEND);

    // Success message
    echo "Registration successful! Welcome, $username.";
} else {
    // Redirect if the page is accessed without submitting the form
    header("Location: register.php");
    exit;
}
?>
