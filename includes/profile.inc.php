<?php
// Include database connection file
include "dbh.inc.php";
session_start();

// Assuming $user_id is obtained from the logged-in user session
$user_id = $_SESSION['id']; // Example user ID

// Retrieve user details from the users table
$sql_user_details = "SELECT * FROM users WHERE id = $user_id";
$result_user_details = $conn->query($sql_user_details);
$user_details = $result_user_details->fetch_assoc();

// Retrieve favorite genre from user_favourite_genre
$sql_favourite_genre = "SELECT genre_name FROM user_favourite_genre WHERE id = $user_id";
$result_favourite_genre = $conn->query($sql_favourite_genre);
$favourite_genre = $result_favourite_genre->fetch_assoc();

// Retrieve read books with book details
$sql_read_books = "SELECT b.* FROM user_book_read ubr 
                   JOIN books b ON ubr.book_id = b.id 
                   WHERE ubr.user_id = $user_id";
$result_read_books = $conn->query($sql_read_books);

// Retrieve wishlist with book details
$sql_wishlist = "SELECT b.* FROM user_book_wishlist ubw 
                 JOIN books b ON ubw.book_id = b.id 
                 WHERE ubw.user_id = $user_id";
$result_wishlist = $conn->query($sql_wishlist);

$sql_user_reviews = "SELECT review.*, users.username, books.title AS book_name, books.author, books.genre 
FROM review 
INNER JOIN users ON review.user_id = users.id 
INNER JOIN books ON review.book_id = books.id
WHERE review.user_id = $user_id
ORDER BY review.posting_time DESC";
$result_user_reviews = $conn->query($sql_user_reviews);

// Retrieve liked books with book details
$sql_liked_books = "SELECT b.* FROM loved_book lb 
                    JOIN books b ON lb.book_id = b.id
                    WHERE lb.user_id = $user_id";
$result_liked_books = $conn->query($sql_liked_books);


?>
