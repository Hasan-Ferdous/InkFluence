<?php
include "dbh.inc.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the search term from the POST data
    $search_term = trim($_POST["search"]);

    // Query to search for books based on the provided search term
    $sql_search = "SELECT id, title, author, genre 
        FROM books 
        WHERE (title LIKE '%$search_term%' OR author LIKE '%$search_term%')";

    // Run the search query
    $result = $conn->query($sql_search);

    

    // Display search results
    
} else {
    // If the form is not submitted, redirect or display an error message
    // Redirect example: header("Location: ../index.php");
    echo "<p>Error: Form not submitted.</p>";
}
?>
