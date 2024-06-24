<?php
include "includes/dbh.inc.php"; // Include your database connection file

if(isset($_POST["book_title"])){
    $bookTitle = $_POST["book_title"];
    $query = "SELECT author, genre FROM books WHERE title = '$bookTitle'";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
    } else{
        echo json_encode(array('author' => '', 'genre' => '')); // Return empty values if book not found
    }
}
?>
