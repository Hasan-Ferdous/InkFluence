<?php

session_start();

// Ensure that user_id and book_id are provided via POST parameters
if (isset($_POST['book_id'])) {
    $user_id = $_SESSION['id'];
    $book_id = $_POST['book_id'];

    include 'dbh.inc.php';

    // Prepare and execute SQL to insert user-book read entry
    $sql = "INSERT INTO user_book_wishlist (user_id, book_id, adding_date) VALUES ('$user_id', '$book_id', NOW())";
    if ($conn->query($sql) === TRUE) {
        // Store the referring page's URL in a session variable
        $_SESSION['return_url'] = $_SERVER['HTTP_REFERER'];

        // Redirect back to the referring page
        header("Location: " . $_SESSION['return_url']);
        exit(); // Ensure no further code is executed after redirection
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
} else {
    echo "User ID and Book ID not provided.";
}
?>