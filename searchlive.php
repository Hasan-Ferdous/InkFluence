<?php
include "includes/dbh.inc.php"; // Include your database connection file

if(isset($_POST["query"])){
    $search = $_POST['query'];
    $query = "SELECT title FROM books WHERE title LIKE '{$search}%'";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            echo '<p>'.$row["title"].'</p>';
            // You can include more book details here if needed
        }
    } else{
        echo '<p>No results found</p>';
    }
}
?>
