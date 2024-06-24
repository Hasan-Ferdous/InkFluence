<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="css/personalize.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Favorite Genre</title>
    
    <style>
        /* Add any additional CSS styling here */
    </style>
</head>
<body>
    <h2>Select Your Favorite Genre</h2>
    <form action="includes/personalize.inc.php" method="post">
    <div class="container">
    <div class="box light-blue" data-value="Fiction">Fiction</div>
<div class="box light-yellow" data-value="Thriller">Thriller</div>
<div class="box light-pink" data-value="Horror">Horror</div>
<div class="box light-orange" data-value="Science Fiction">Science Fiction</div>
<div class="box light-purple" data-value="Romance">Romance</div>
<div class="box light-pink" data-value="Satire">Satire</div>
<div class="box light-green" data-value="Fantasy">Fantasy</div>
<div class="box light-teal" data-value="Coming-of-Age">Coming-of-Age</div>
<div class="box light-lime" data-value="Dystopian">Dystopian</div>
<div class="box light-gray" data-value="Political Satire">Political Satire</div>
<div class="box light-yellow" data-value="Survival">Survival</div>
<div class="box light-cyan" data-value="Adventure">Adventure</div>
<div class="box light-lavender" data-value="Children's Literature">Children's Literature</div>
<div class="box light-rose" data-value="Epic Poetry">Epic Poetry</div>
<div class="box light-pink" data-value="Psychological Fiction">Psychological Fiction</div>
<div class="box light-indigo" data-value="Gothic Fiction">Gothic Fiction</div>
<div class="box light-yellow" data-value="Realist Fiction">Realist Fiction</div>
<div class="box light-orange" data-value="Autobiographical Fiction">Autobiographical Fiction</div>
<div class="box light-green" data-value="Magic Realism">Magic Realism</div>
<div class="box light-cyan" data-value="Post-Apocalyptic">Post-Apocalyptic</div>
<div class="box light-gray" data-value="Social Commentary">Social Commentary</div>
<div class="box light-steel" data-value="Philosophical Fiction">Philosophical Fiction</div>
<div class="box light-brown" data-value="Historical Fiction">Historical Fiction</div>

    
    
    
</div>

        <input type="hidden" id="selectedGenres" name="genre[]">
        <input type="submit" value="Save" class="save-button">
    </form>

    <script>
        // JavaScript for selecting/deselecting boxes
        const boxes = document.querySelectorAll('.box');
        const selectedGenresInput = document.getElementById('selectedGenres');

        let selectedGenres = [];

        boxes.forEach((box) => {
            box.addEventListener('click', () => {
                box.classList.toggle('selected');
                const value = box.getAttribute('data-value');
                if (box.classList.contains('selected')) {
                    selectedGenres.push(value);
                } else {
                    const indexToRemove = selectedGenres.indexOf(value);
                    if (indexToRemove !== -1) {
                        selectedGenres.splice(indexToRemove, 1);
                    }
                }
                selectedGenresInput.value = selectedGenres.join(',');
            });
        });
    </script>
</body>
</html>
