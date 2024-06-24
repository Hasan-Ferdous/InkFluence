<?php
include 'includes/search.inc.php';

$search_results = array(); // Array to store search results
$related_books_ids = array(); // Array to store IDs of search results for suggesting similar books

echo "<div class='container_books'>";

if ($result->num_rows > 0) {
    // Display search results and store IDs
    while ($row = $result->fetch_assoc()) {
        $search_results[] = $row;
        $related_books_ids[] = $row['id'];
    }
    echo "<div class='books'>";
    // Display search results
    foreach ($search_results as $row) {
        echo "<div class='card'>";
        // URL encode the title before using it in the URL
        $encoded_title = urlencode($row["title"]);
        $save_directory = "book_cover/";
        $filename = md5($encoded_title) . ".jpg"; // Using MD5 hash for uniqueness
        $save_path = $save_directory . $filename;

        if (!file_exists($save_path)) {
            // Download the book cover to your server if not already downloaded
            $api_key = "AIzaSyAALlAV4We348VTqK18QTDgSQgb9WlpBR4";
            $book_title = urlencode($row["title"]);
            $google_books_url = "https://www.googleapis.com/books/v1/volumes?q=" . $book_title . "&key=" . $api_key;
            $response = file_get_contents($google_books_url);
            $data = json_decode($response, true);

            if (isset($data['items'][0]['volumeInfo']['imageLinks']['thumbnail'])) {
                $book_cover_url = $data['items'][0]['volumeInfo']['imageLinks']['thumbnail'];
                file_put_contents($save_path, file_get_contents($book_cover_url));
            } else {
                // Default cover image if cover not found
                $save_path = "default_cover.jpg";
            }
        }
        $book_id = $row["id"]; 
        echo "<img src='$save_path' class='card-img-top' alt='...'>";
        // Make the book name a clickable link
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'><a href='another_page.php?book_id=$book_id&bookname=$encoded_title&writername=" . urlencode($row["author"]) . "&genre=" . urlencode($row["genre"]) . "'>" . $row["title"] . "</a></h5>";
        echo "<h6 class='card-subtitle mb-2 text-muted'><a href='another_page.php?book_id=$book_id&bookname=$encoded_title&writername=" . urlencode($row["author"]) . "&genre=" . urlencode($row["genre"]) . "'>" . $row["author"] . "</a></h6>";
        echo '</div>';
        echo '</div>';
    }
}

echo "</div>";

// Store related books IDs for suggesting similar books
$related_books_ids_str = implode(',', $related_books_ids);

// Now, you can use $related_books_ids_str to suggest similar books based on these IDs.
?>
