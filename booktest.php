<?php

include './conn.php';

class Book {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getBooks($title, $author, $year) {
        // Build the SQL query based on the search criteria provided
        $sql = "SELECT * FROM sidan_book WHERE 1";
        
        if (!empty($title)) {
            $sql .= " AND Title LIKE '%$title%'";
        }
        
        if (!empty($author)) {
            $sql .= " AND Author LIKE '%$author%'";
        }
        
        if (!empty($year)) {
            $sql .= " AND Publication_Year = $year";
        }

        // Execute the query
        $result = $this->conn->query($sql);

        // Check if any books were found
        if ($result->num_rows > 0) {
            // Fetch associative array of books
            $books = array();
            while ($row = $result->fetch_assoc()) {
                $books[] = $row;
            }
            return $books;
        } else {
            // If no books found, return empty array
            return array();
        }
    }

    public function addBook($new_title, $new_author, $new_year) {
        // Prepare the SQL statement for inserting a new book
        $sql = "INSERT INTO sidan_book (Title, Author, Publication_Year) VALUES (?, ?, ?)";
        
        // Prepare the SQL statement
        $stmt = $this->conn->prepare($sql);
        
        // Bind parameters to the prepared statement
        $stmt->bind_param("ssi", $new_title, $new_author, $new_year);
        
        // Execute the prepared statement
        if ($stmt->execute()) {
            // If insertion is successful, return true
            return true;
        } else {
            // If insertion fails, return false
            return false;
        }
    }
}

// Instantiate Book object
$book = new Book($conn);

// Retrieve search parameters from form submission
$title = $_POST['title'] ?? '';
$author = $_POST['author'] ?? '';
$year = $_POST['year'] ?? '';

// Call getBooks method to retrieve books based on search criteria
$books = $book->getBooks($title, $author, $year);

// Display search results
foreach ($books as $book) {
    echo "Book ID: " . $book['Book_ID'] . "<br>";
    echo "Title: " . $book['Title'] . "<br>";
    echo "Author: " . $book['Author'] . "<br>";
    echo "Publication Year: " . $book['Publication_Year'] . "<br>";
    echo "<br>";
}
?>
