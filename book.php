<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect user to the login page if not logged in
    header("Location: login.php");
    exit;
}

// Reuse the existing database connection from the session
$conn = $_SESSION['conn'];

class Book {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getBooks($title, $author, $year) {
        // Build the SQL query based on the search criteria provided
        $sql = "SELECT * FROM books WHERE 1";
        
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

    public function addBook($title, $author, $year) {
        // Prepare the SQL statement for inserting a new book
        $sql = "INSERT INTO books (Title, Author, Publication_Year) VALUES (?, ?, ?)";
        
        // Prepare the SQL statement
        $stmt = $this->conn->prepare($sql);
        
        // Bind parameters to the prepared statement
        $stmt->bind_param("ssi", $title, $author, $year);
        
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
