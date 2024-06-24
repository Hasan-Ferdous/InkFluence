<?php
include "includes/dbh.inc.php";


// Get user's ID
$user_id = $_SESSION['id'];  // Example user ID

// Query to fetch books based on user's favorite genre


$sql_genre = "SELECT b.id, b.title, b.author, b.genre
        FROM books b 
        JOIN user_favourite_genre ufg ON FIND_IN_SET(b.genre, ufg.genre_name) > 0
        WHERE ufg.id = $user_id
        AND b.id NOT IN (
            SELECT book_id FROM user_book_read WHERE user_id = $user_id
            UNION
            SELECT book_id FROM user_book_wishlist WHERE user_id = $user_id
        )
        AND b.id NOT IN (
            SELECT book_id FROM review WHERE user_id = $user_id
        )";


// Query to fetch books liked by the user
$sql_liked_books = "SELECT b.id, b.title, b.author, b.genre
        FROM books b
        JOIN loved_book lb ON b.id = lb.book_id
        WHERE lb.user_id = $user_id
        AND b.id NOT IN (
            SELECT book_id FROM user_book_read WHERE user_id = $user_id
            UNION
            SELECT book_id FROM user_book_wishlist WHERE user_id = $user_id
        )
        AND b.id NOT IN (
            SELECT book_id FROM review WHERE user_id = $user_id
        )";

// Combine the results of both queries
$sql_combined = "($sql_genre) UNION ($sql_liked_books)";

// Run the combined query
$result = $conn->query($sql_combined);
