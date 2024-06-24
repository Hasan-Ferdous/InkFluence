<?php 
            $encoded_title = urlencode($row_wishlist["title"]);
            $save_directory = "book_cover/";
            $filename = md5($encoded_title) . ".jpg"; // Using MD5 hash for uniqueness
            $save_path = $save_directory . $filename;

            if (!file_exists($save_path)) {
                // Download the book cover to your server if not already downloaded
                $api_key = "AIzaSyAALlAV4We348VTqK18QTDgSQgb9WlpBR4";
                $book_title = urlencode($row_wishlist["title"]);
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
?>