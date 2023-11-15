<!DOCTYPE html>
<html>
<head>
    <title>View Books</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body style="background-image: url('img/5.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <header>
        <h1>View Books</h1>
        <nav>
            <a href="index.html">Home</a>
<a href="index.html">Logout</a>
            <a href="add_book.html">Add Book</a>
		<a href="contact.html">Contact US</a>
            <!--<a href="logout.php">Logout</a> Add a logout link if you have a logout script -->
        </nav>
    </header>
    <section class="content">
        <h2>List of Books</h2>
        <table>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Description</th>
                <th>Availability</th>
                <th>Actions</th>
            </tr>
            <?php
            require_once('config.php');

            // Retrieve the list of added books
            $sql = "SELECT * FROM books";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["title"] . "</td>";
                    echo "<td>" . $row["author"] . "</td>";
                    echo "<td>" . $row["description"] . "</td>";
                    echo "<td>" . ($row["availability"] ? "Available" : "Unavailable") . "</td>";
                    echo "<td>";
                    echo "<button onclick=\"modifyBook(" . $row["id"] . ")\">Modify</button>";
                    echo "<button onclick=\"deleteBook(" . $row["id"] . ")\">Delete</button>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No books found.</td></tr>";
            }

            $conn->close();
            ?>
        </table>
    </section>

    <script>
	function modifyBook(bookId) {
    // Redirect to the "Modify Book" page with the bookId as a query parameter
    window.location.href = "modify_book.php?bookId=" + bookId;
}




        function deleteBook(bookId) {
    // Show a confirmation dialog
    if (confirm("Are you sure you want to delete this book?")) {
        // Make an AJAX request to the delete book PHP script
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "delete_book.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Handle the response from the delete book PHP script
                alert(xhr.responseText);
                // Reload the page to reflect the updated book list
                location.reload();
            }
        };
        // Send the bookId as a POST parameter to the PHP script
        xhr.send("book_id=" + bookId);
    }
}

    </script>
<footer>
        &copy; 2023 Library. All rights reserved.
    </footer>
</body>
</html>
