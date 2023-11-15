<?php
require_once('config.php');

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username exists
    $check_sql = "SELECT username, password FROM users WHERE username = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $check_stmt->bind_result($db_username, $db_password);

    if ($check_stmt->fetch() && $password === $db_password) {
        session_start();
        $_SESSION['username'] = $db_username;
        header("Location: add_book.html");
	//echo "Login Successful.";
    } else {
        echo "Login failed. Please check your credentials.";
    }

    $check_stmt->close();
}
?>
