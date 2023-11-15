<?php
require_once('config.php');

if (isset($_POST['book_id'])) {
    $bookId = $_POST['book_id'];

    // Add validation and error handling as needed

    // Delete the book from the database
    $sql = "DELETE FROM books WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookId);

    if ($stmt->execute()) {
        // Deletion successful
        echo "Book deleted successfully.";
    } else {
        // Deletion failed
        echo "Error deleting the book: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
