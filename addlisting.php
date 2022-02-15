<?php
  
    session_start();

    require_once("config.php");
    
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(!empty($_POST['passingImages']))
        {
            $passingImages = json_decode($_POST['passingImages'], true);
            echo count($passingImages) . '<br>';

            for($i = 0; $i < count($_FILES['galleryphotos']['name']); $i++) {
                if(in_array(trim($_FILES['galleryphotos']['name'][$i]), $passingImages)) {
                    echo $i . '<br />';
                }
            }
        }

        
        for($i = 0; $i < count($_POST['question']); $i++) {
            if(isset($_POST['question'][$i]) && !empty($_POST['question'][$i]))
            {
                if(!isset($_POST['answer'][$i]) || empty($_POST['answer'][$i]))
                {
                    echo '<p>Pitanje broj ' . $i+1 . ' nema odgovora.</p>';
                }
                else { echo '<p>Pitanje broj ' . $i+1 . ' ima odgovor.<br>' . $_POST['question'][$i] . '- ' . $_POST['answer'][$i] . '.</p><br>'; }
            }
        }
    }
?>

<!DOCTYPE html>
<html>

    <head>
        <?php include "blocks/header.html"; ?>
        <script src="js/jQuery.tagify.min.js"></script>
        <script src="js/tagify.polyfills.min.js"></script>
        <link rel="stylesheet" href="styles/tagify.css">
    </head>

    <body>

        <?php include "blocks/nav.php"; ?>
        <?php include "blocks/mobilenav.php"; ?>

        <section id="packages">

            <div class="card">
                <h3>Basic</h3>
                <div class="price">
                    €0.00&nbsp;
                    <p>/ mjesečno</p>
                </div>
                <span class="card-divider"></span>
                <div class="card-item">
                    <i class="fa-solid fa-xmark fa-fw packageexcluded"></i>
                    <p><s>Izdvojen listing</s></p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Adresa</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Telefon</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Radno vrijeme</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Lokacija</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-xmark fa-fw packageexcluded"></i>
                    <p><s>Lokacija na mapi</s></p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-xmark fa-fw packageexcluded"></i>
                    <p><s>Značajke</s></p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-xmark fa-fw packageexcluded"></i>
                    <p><s>Često postavljena pitanja</s></p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-xmark fa-fw packageexcluded"></i>
                    <p><s>Socijalne mreže</s></p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-xmark fa-fw packageexcluded"></i>
                    <p><s>Kontrola recenzija</s></p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-xmark fa-fw packageexcluded"></i>
                    <p><s>Galerija (10 slika max. 3MB)</s></p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-xmark fa-fw packageexcluded"></i>
                    <p><s>Eventi</s></p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-xmark fa-fw packageexcluded"></i>
                    <p><s>Bez oglasa na listingu</s></p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-xmark fa-fw packageexcluded"></i>
                    <p><s>Vlastite oznake</s></p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-xmark fa-fw packageexcluded"></i>
                    <p><s>Cjenovnik</s></p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-xmark fa-fw packageexcluded"></i>
                    <p><s>Nadzorna ploča</s></p>
                </div>
                <button type="button" data-plan="basic" class="filled">Odaberi</button>
            </div>

            <div class="card">
                <h3>Standard</h3>
                <div class="price">
                    €7.50&nbsp;
                    <p>/ mjesečno</p>
                </div>
                <span class="card-divider"></span>
                <div class="card-item">
                    <i class="fa-solid fa-xmark fa-fw packageexcluded"></i>
                    <p><s>Izdvojen listing</s></p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Adresa</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Telefon</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Radno vrijeme</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Lokacija</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Lokacija na mapi</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Značajke</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-xmark fa-fw packageexcluded"></i>
                    <p><s>Često postavljena pitanja</s></p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Socijalne mreže</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Kontrola recenzija</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Galerija (5 slika max. 2MB)</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-xmark fa-fw packageexcluded"></i>
                    <p><s>Eventi</s></p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-xmark fa-fw packageexcluded"></i>
                    <p><s>Bez oglasa na listingu</s></p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-xmark fa-fw packageexcluded"></i>
                    <p><s>Vlastite oznake</s></p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Cjenovnik</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-xmark fa-fw packageexcluded"></i>
                    <p><s>Nadzorna ploča</s></p>
                </div>
                <button type="button" data-plan="standard" class="filled">Odaberi</button>
            </div>

            <div class="card">
                <h3>Premium <i class="fa-solid fa-award fa-fw" style="color: var(--muted-color);"></i></h3>
                <div class="price">
                    €12.50&nbsp;
                    <p>/ mjesečno</p>
                </div>
                <span class="card-divider"></span>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Izdvojen listing</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Adresa</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Telefon</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Radno vrijeme</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Lokacija</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Lokacija na mapi</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Značajke</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Često postavljena pitanja</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Socijalne mreže</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Kontrola recenzija</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Galerija (10 slika max. 3MB)</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Eventi</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Bez oglasa na listingu</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Vlastite oznake</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Cjenovnik</p>
                </div>
                <div class="card-item">
                    <i class="fa-solid fa-check fa-fw packageincluded"></i>
                    <p>Nadzorna ploča</p>
                </div>
                <button type="button" data-plan="premium" class="filled">Odaberi</button>
            </div>

        </section>

        <section id="newlisting">

        </section>

        <?php include "blocks/footer.php"; ?>
        <script src="js/addlisting.js"></script>

    </body>

    <footer>
    </footer>

</html>