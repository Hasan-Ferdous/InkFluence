<?php
session_start();
include 'dbh.inc.php';

if(isset($_POST['submit'])) { // Check if the form is submitted

    $book_name = mysqli_real_escape_string($conn, $_POST['book_name']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $review = mysqli_real_escape_string($conn, $_POST['review']);

    if(empty($book_name) || empty($author) || empty($genre) || empty($review)) {
        // Redirect back to the form with an error if any field is empty
        header("Location:../write_review.php?error=empty");
        exit();
    }

    // Check if the book exists in the book table
    $check_book_sql = "SELECT * FROM books WHERE title = '$book_name'";
    $check_book_result = mysqli_query($conn, $check_book_sql);

    if(mysqli_num_rows($check_book_result) == 0) { // Book does not exist, insert into book table
        $insert_book_sql = "INSERT INTO books (title, author, genre, cover_image_url) 
                            VALUES ('$book_name', '$author', '$genre', 'not found')";
        if(mysqli_query($conn, $insert_book_sql)) {
            // Get the auto-generated book_id after insertion
            $book_id = mysqli_insert_id($conn);
        } else {
            // Redirect back to the form with an error if insertion into book table fails
            header("Location:../write_review.php?error=insert_book");
            exit();
        }
    } else {
        // Book exists, retrieve its book_id
        $row = mysqli_fetch_assoc($check_book_result);
        $book_id = $row['id'];
    }

    // Assuming $_SESSION['id'] holds the user's ID
    $user_id = $_SESSION['id'];

    // Insert review into review table
    $insert_review_sql = "INSERT INTO review (user_id, book_id, posting_time, review_text) 
                          VALUES ('$user_id', '$book_id', NOW(), '$review')";
    if(mysqli_query($conn, $insert_review_sql)) {
        // Redirect to a success page or wherever you want after successful insertion
        header("Location:../homepage.php");
        exit();
    } else {
        // Redirect back to the form with an error if insertion into review table fails
        header("Location:../write_review.php?error=insert_review");
        exit();
    }

} else {
    // Redirect back to the form if the submit button is not clicked
    header("Location:../write_review.php?error=submit");
    exit();
}
?>
