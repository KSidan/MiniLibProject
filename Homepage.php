<?php

session_start();

if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
?>

<html lang="en">
<head>
    <style>
    body, html {
        font-family: Arial, Helvetica, sans-serif;
        height: 100%;
        margin: 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    </style>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Database</title>
</head>
<body>
    <h1>Welcome, <?php echo $username; ?></h1>
    <h2>What do you want to do today?</h2>

    <!-- Search form -->
    <form method="post" action="book.php">
        <label for="title">Search by Title:</label><br>
        <input type="text" id="title" name="title" placeholder="Enter book title"><br><br>

        <label for="author">Search by Author:</label><br>
        <input type="text" id="author" name="author" placeholder="Enter author name"><br><br>

        <label for="year">Search by Publication Year:</label><br>
        <input type="number" id="year" name="year" placeholder="Enter publication year"><br><br>

        <button type="submit">Search</button>
    </form>

    <h2>Add a New Book</h2>
    <form method="post" action="add_book.php">
        <label for="new_title">Title:</label><br>
        <input type="text" id="new_title" name="new_title" placeholder="Enter book title"><br><br>

        <label for="new_author">Author:</label><br>
        <input type="text" id="new_author" name="new_author" placeholder="Enter author name"><br><br>

        <label for="new_year">Publication Year:</label><br>
        <input type="number" id="new_year" name="new_year" placeholder="Enter publication year"><br><br>

        <button type="submit">Add Book</button>
    </form>
</body>
</html>
