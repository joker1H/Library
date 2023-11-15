<?php
require_once('config.php');

if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if the username already exists
    $check_sql = "SELECT username FROM users WHERE username = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "Username already exists. Please choose a different one.";
    } elseif ($password !== $confirm_password) {
        echo "Passwords do not match. Please try again.";
    } else {
        // Insert the user into the database
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);

        if ($stmt->execute()) { // Fixed the variable name here
            echo "Registration successful!";
        } else {
            echo "Error: " . $conn->error;
        }
    }

    $check_stmt->close(); // Close the check statement
}
?>
