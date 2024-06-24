<!-- Book Display Section -->
<div class="container_books">
    <?php
    echo "<div class='books'>";
    if ($result->num_rows > 0) {
        // Define absolute path to save directory
        $save_directory = "book_cover\\";
        // Create directory if it doesn't exist
        if (!file_exists($save_directory)) {
            mkdir($save_directory, 0777, true);
        }

        while ($row = $result->fetch_assoc()) {
            echo "<div class='card'>";
            $api_key = "AIzaSyAALlAV4We348VTqK18QTDgSQgb9WlpBR4";
            $book_title = urlencode($row["title"]);
            // Sanitize the filename
            $filename = md5($book_title) . ".jpg"; // Using MD5 hash for uniqueness
            $save_path = $save_directory . $filename;

            if (!file_exists($save_path)) {
                // Download the book cover to your server if not already downloaded
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
            echo "<img src='$save_path' class='card-img-top' alt='Book Cover'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'><a href='another_page.php?book_id=$book_id&bookname=$book_title&writername=" . urlencode($row["author"]) . "&genre=" . urlencode($row["genre"]) . "'>" . $row["title"] . "</a></h5>";
            echo "<h6 class='card-subtitle mb-2 text-muted'><a href='another_page.php?book_id=$book_id&bookname=$book_title&writername=" . urlencode($row["author"]) . "&genre=" . urlencode($row["genre"]) . "'>" . $row["author"] . "</a></h6>";
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "No books found.";
    }
    echo "</div>";
    ?>
</div>
