<?php
// Include your database connection (config.php)
require_once('config.php');

if (isset($_POST['add_book'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $description = $_POST['description'];
    $availability = $_POST['availability'];

    $sql = "INSERT INTO books (title, author, description, availability) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $title, $author, $description, $availability);

$title = $_POST['title'];
$author = $_POST['author'];
$description = $_POST['description'];
$availability = ($_POST['availability'] == 'available') ? 1 : 0; // Set availability based on the form input

if ($stmt->execute()) {
    echo "Book added successfully!";
} else {
    echo "Error: " . $conn->error;
}

}
?>
