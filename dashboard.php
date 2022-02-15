<?php
  
    session_start();

    require_once("config.php");

?>

<!DOCTYPE html>
<html>

    <head>
        <?php include "blocks/header.html"; ?>
        <script src="js/dashboard.js"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap" rel="stylesheet">
    </head>

    <body>

        <?php include "blocks/template.html"; ?>

        <div id="main-content">

            <div class="wrapper categorycreation">
                <form action="formvalidation/createcategory.php" class="category-creation" method="POST">

                    <div class="inputwrapper">
                        <label for="category-name">Naziv kategorije:
                        <input type="text" name="nazivkategorije" placeholder="unesite naziv">
                    </div>

                    <div class="inputwrapper">
                        <label for="category-feature">Značajke kategorije:
                        <input type="text" name="znacajkekategorije[]" placeholder="unesite značajku">
                    </div>

                    <button type="button" class="addfeature">Dodaj</button>

                    <button type="submit">Pošalji</button>

                </form>
            </div>

            
        </div>

    </body>

    <footer>
        <script> </script>
    </footer>

</html>