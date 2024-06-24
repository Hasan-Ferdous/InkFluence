<?php
session_start();
include 'dbh.inc.php';

// Check if the love button is clicked
if(isset($_POST['love_review_id'])) {
    $reviewId = $_POST['love_review_id'];
    $book_id= $_POST['book_id'];
    $user_id = $_SESSION['id'];

    // Check if the user has already loved the review
    $checkSql = "SELECT * FROM loved_book WHERE user_id = $user_id AND review_id = $reviewId";
    $resultCheck = mysqli_query($conn, $checkSql);

    if(mysqli_num_rows($resultCheck) == 0) {
        // Update the loved index in the review table
        $updateSql = "UPDATE review 
                      SET love_index = love_index + 1
                      WHERE review_id = $reviewId";

        // Execute the update query
        $resultUpdate = mysqli_query($conn, $updateSql);

        // Check if the update query was successful
        if($resultUpdate) {
            // Insert into the loved_book table
            $insertSql = "INSERT INTO loved_book (user_id,book_id,review_id) 
                          VALUES ($user_id,$book_id,$reviewId)";
            
            // Execute the insert query
            $resultInsert = mysqli_query($conn, $insertSql);

            // Check if the insert query was successful
            if(!$resultInsert) {
                // Handle the insert query error
                // Redirect or display error message
            } else {
                // Redirect to homepage if everything is successful
                header("Location: ../community.php");
                exit();
            }
        } else {
            // Handle the update query error
            // Redirect or display error message
        }
    } else {
        // If the review is already loved, decrease the love index
        // Update the loved index in the review table
        $updateSql = "UPDATE review 
                      SET love_index = love_index - 1
                      WHERE review_id = $reviewId";

        // Execute the update query
        $resultUpdate = mysqli_query($conn, $updateSql);

        // Check if the update query was successful
        if($resultUpdate) {
            // Delete the record from the loved_book table
            $deleteSql = "DELETE FROM loved_book WHERE user_id = $user_id AND review_id = $reviewId";

            // Execute the delete query
            $resultDelete = mysqli_query($conn, $deleteSql);

            // Check if the delete query was successful
            if(!$resultDelete) {
                // Handle the delete query error
                // Redirect or display error message
            } else {
                // Redirect to homepage if everything is successful
                header("Location: ../community.php");
                exit();
            }
        } else {
            // Handle the update query error
            // Redirect or display error message
        }
    }
}

?>
