<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '_dbconnect.php';  // Connect to the database

    // Retrieve form data
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate fields
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        header("Location: _handleSignup.php?error=Please fill in all fields");
        exit();
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        header("Location: _handleSignup.php?error=Passwords do not match");
        exit();
    }

    // Hash the password for secure storage
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if the email already exists
    $checkUserQuery = "SELECT * FROM `users` WHERE `user_email` = ?";
    $stmt = $conn->prepare($checkUserQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email exists
        header("Location: _handleSignup.php?error=Email already exists");
        exit();
    }

    // Insert the new user into the database
    $insertQuery = "INSERT INTO `users` (`username`, `user_email`, `user_pass`, `timestamp`) VALUES (?, ?, ?, current_timestamp())";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sss", $username, $email, $hashed_password);
    if ($stmt->execute()) {
        // Redirect with success message
        header("Location: _handleSignup.php?success=Account created successfully!");
        exit();
    } else {
        // Something went wrong
        header("Location: _handleSignup.php?error=Could not create account. Please try again.");
        exit();
    }
}
?>
