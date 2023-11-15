<?php
require_once('config.php');

if (isset($_POST['bookId'])) {
    $bookId = $_POST['bookId'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $description = $_POST['description'];
    $availability = $_POST['availability'];

    $sql = "UPDATE books SET title = ?, author = ?, description = ?, availability = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $title, $author, $description, $availability, $bookId);

    if ($stmt->execute()) {
        echo "Book modified successfully.";
    } else {
        echo "Error modifying the book: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
