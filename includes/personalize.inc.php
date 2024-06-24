<?php
include 'dbh.inc.php';
session_start();
$id=$_SESSION['id'];
echo $id;
// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if genres are selected
    if(isset($_POST['genre'])) {
        // Prepare SQL statement to insert selected genres for the user
        $stmt = $conn->prepare("INSERT INTO user_favourite_genre (id, genre_name) VALUES (?, ?)");
        
        // Bind parameters
        $stmt->bind_param("is", $id, $genre_name);
        
        // Iterate over selected genres and insert them into the database
        foreach ($_POST['genre'] as $genre) {
            $genre_name = $genre;
            $stmt->execute();
        }
        
        // Close statement
        $stmt->close();
        
        // Redirect to a confirmation page or do whatever is needed
        header("Location:../homepage.php");
        exit();
    } else {
        // No genres selected
        echo "Please select at least one genre.";
    }
}

// Close connection
$conn->close();
?>
