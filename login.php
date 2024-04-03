<?php
// Include the connection file if not already included
include 'conn.php';

// Define a class for user authentication
class UserAuthentication {
    private $conn;

    // Constructor to initialize the database connection
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // Method to authenticate user
    public function authenticateUser($username, $password) {
        session_start();

        if(isset($username, $password)) {
            $username = $this->conn->real_escape_string($username);
            $password = $this->conn->real_escape_string($password);

            $sql = "SELECT * FROM users_table WHERE user_name='$username' AND password='$password'";
            $result = $this->conn->query($sql);

            if ($result->num_rows > 0) {
                $_SESSION['logged_in'] = true;
                header("Location: homepage.php");
                exit(); // Stop further execution after redirection
            } else {
                echo "Invalid username or password.";
            }
        } else {
            echo "Please provide username and password.";
        }
    }
}

// Usage:
// Create an instance of the class and pass the database connection
$userAuth = new UserAuthentication($conn);

// Check if form is submitted and call the authenticateUser method
if(isset($_POST['username'], $_POST['password'])) {
    $userAuth->authenticateUser($_POST['username'], $_POST['password']);
}

// Close the database connection
$conn->close();
?>
