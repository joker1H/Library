<!DOCTYPE html>
<html>
<head>
    <title>Modify Book</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body style="background-image: url('img/6.png'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    <header>
        <h1>Modify Book</h1>
        <nav>
            <a href="index.html">Home</a>
            <a href="add_book.html">Add Book</a>
            <!-- Add a logout link if you have a logout script -->
        </nav>
    </header>
    <section class="content">
        <h2>Modify Book</h2>
        <?php
        require_once('config.php');

        if (isset($_GET['bookId'])) {
            $bookId = $_GET['bookId'];
            $sql = "SELECT * FROM books WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $bookId);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
        ?>
        <form method="post" action="">
            <input type="hidden" name="bookId" value="<?php echo $bookId; ?>">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" value="<?php echo $row['title']; ?>" required><br>

            <label for="author">Author:</label>
            <input type="text" name="author" id="author" value="<?php echo $row['author']; ?>" required><br>

            <label for="description">Description:</label>
            <textarea name="description" id="description" required><?php echo $row['description']; ?></textarea><br>

            <label for="availability">Availability:</label>
            <select name="availability" id="availability" required>
                <option value="available" <?php echo ($row['availability'] ? 'selected' : ''); ?>>Available</option>
                <option value="unavailable" <?php echo ($row['availability'] ? '' : 'selected'); ?>>Unavailable</option>
            </select><br>

            <button type="button" onclick="modifyBook()">Modify Book</button>
        </form>
        <div id="confirmationMessage"></div>
        <script>
    function modifyBook() {
        // Get the form data
        var bookId = <?php echo $bookId; ?>;
        var title = document.getElementById("title").value;
        var author = document.getElementById("author").value;
        var description = document.getElementById("description").value;
        var availability = document.getElementById("availability").value;

        // Create an AJAX request
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "modify_book_process.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        // Define the data to send
        var data = "bookId=" + bookId + "&title=" + title + "&author=" + author + "&description=" + description + "&availability=" + availability;

        // Set up the callback function
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var confirmationMessage = document.getElementById("confirmationMessage");
                confirmationMessage.innerHTML = xhr.responseText;
            }
        };

        // Send the data
        xhr.send(data);
    }
</script>

        <?php
            } else {
                echo "Book not found.";
            }
        } else {
            echo "Book ID not provided.";
        }
        $conn->close();
        ?>
    </section>
<footer>
        &copy; 2023 Library. All rights reserved.
    </footer>
</body>
</html>
