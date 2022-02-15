<?php

    require_once(dirname(__DIR__) . "/config.php");


    if($_REQUEST['funkcija'] === 'populateDropdowns')
    {
        if(!empty($_REQUEST['pretraga']))
        {
            $_term = '%' . trim($_REQUEST['pretraga']) . '%';		

            $sql = "SELECT * FROM listing WHERE `naziv` LIKE ? OR `adresa` LIKE ? OR JSON_EXTRACT(listingData, '$.kljucneRijeci') LIKE ? OR `kategorija` LIKE ? ORDER BY `plan` DESC, `naziv` DESC, `id` DESC LIMIT 5";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $_term);
            $stmt->bindParam(2, $_term);
            $stmt->bindParam(3, $_term);
            $stmt->bindParam(4, $_term);
            $stmt->execute();

            $count = $stmt->rowCount();

            if($count != 0)
            {
                while($row = $stmt->fetch())
                {
                    $_galleryData = json_decode($row['galleryData'], true);
                    if($row['prosjecnaOcjena'] == 0) { $ocjena = 'Nema recenzija'; }
                    else { $ocjena = '<i class="fa-solid fa-star"></i> ' . $row['prosjecnaOcjena'] . '</p>&bull;<p>' . $row['brojRecenzija'] . ' recenzija'; }

                    echo '<div class="search-result">';

                        if(empty($_galleryData['slike'])) { echo '<img id="ajax-placeholder" src="images/listing-placeholder-logo.png">'; }
                        else { echo '<img id="ajax-search" src=".' . $_galleryData['putanja'] . $_galleryData['slike'][0] . '">'; }

                        echo '<div class="data">';
                            echo '<div class="ajax-info"><a href="#"><h6 class="ajax-title">' . htmlspecialchars($row['naziv']) . '</h5></a></div>';
                            echo '<p class="ajax-data"><i class="fa-solid fa-location-dot fa-fw" style="color: var(--layout);"></i>' . htmlspecialchars($row['adresa']) . '</p>';
                            echo '<div class="ajax-info"><p class="ajax-data">' . htmlspecialchars($row['kategorija']) . '</p>&bull;<p class="ajax-data">' . $ocjena . '</p></div>';
                        echo '</div>';
                    echo '</div>';
                }
            }

            echo '<p class="results-found">Pronađeno rezultata: ' . $count . '</p>'; 
        }

        if(!empty($_REQUEST['kategorija']))
        {
            $_kategorija = trim($_REQUEST['kategorija']) . "%";

            $sql = "SELECT * FROM `kategorije` WHERE `naziv` LIKE ?";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $_kategorija);

            $stmt->execute();

            if($stmt->rowCount() == 0) { echo '<p class="results-found">Nema rezultata</p>';}

            while($row = $stmt->fetch())
            {
                echo '<p class="no-indent">' . htmlspecialchars($row['naziv']) . '</p>';
                if(!empty($row['podkategorije'])) {
                    foreach(json_decode($row['podkategorije']) as $podkategorija) {
                    echo '<p class="indent">' . htmlspecialchars($podkategorija) . '</p>'; } 
                }
            }
        }

        if(!empty($_REQUEST['grad']))
        {
            $_grad = trim($_REQUEST['grad']) . "%";

            $sql = "SELECT * FROM `gradovi` WHERE `naziv` LIKE ?";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(1, $_grad);

            $stmt->execute();

            if($stmt->rowCount() == 0) { echo '<p class="results-found">Nema rezultata</p>';}

            while($row = $stmt->fetch())
            {
                echo '<p class="no-indent">' . htmlspecialchars($row['naziv']) . '</p>';
            }
        }

    }

    else if($_REQUEST['funkcija'] === 'countForFront')
    {
        $_kategorija = trim($_REQUEST['frontpage-kat']) . "%";
        $_grad = "%" . trim($_REQUEST['frontpage-grad']) . "%";

        $sql = "SELECT COUNT(*) as `zbir` FROM `listing` WHERE `kategorija` LIKE :kat AND `adresa` LIKE :grad";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
                            ":kat" => $_kategorija,
                            ":grad" => $_grad));

        while($row = $stmt->fetch()) {
            if($row['zbir'] == 0) { $_count = "Nema rezultata"; }
            else { $_count = 'Traži ' . $row['zbir'] . ' rezultata<i class="fa-solid fa-angle-right fa-fw" style="text-align: right;"></i>'; }
        }

        echo $_count;

    }
?>