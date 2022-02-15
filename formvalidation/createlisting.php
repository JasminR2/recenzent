<?php

    header("Content-Type: application/json");

    require_once(dirname(__DIR__) . "/config.php");

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        /*========================= VARIJABLE =========================*/
        $_kategorija = $_podkategorija = $_naziv = $_kontakt = $_grad = $_ulica = $_postanski = '';
        $_covidRegulative = array();
        $_radnoVrijeme = array();
        $_galleryPhotos = array();
        $_errors = array();

        /*========================= OBAVEZNI PODATCI =========================*/
        /*===== GENERALNO =====*/
        if(isset($_POST['kategorija']) && !empty($_POST['kategorija'])) { $_kategorija = trim($_POST['kategorija']); }
        else { $_errors[] = 'kategorija'; }

        if(isset($_POST['nazivlistinga']) && !empty($_POST['nazivlistinga'])) { $_naziv = trim($_POST['nazivlistinga']); }
        else { $_errors[] = 'nazivlistinga'; }

        if(isset($_POST['kontakttelefon']) && !empty($_POST['kontakttelefon'])) { $_kontakt = trim($_POST['kontakttelefon']); }
        else { $_errors[] = 'kontakttelefon'; }

        /*===== LOKACIJA =====*/
        if(isset($_POST['grad']) && !empty($_POST['grad'])) { $_grad = trim($_POST['grad']); }
        else { $_errors[] = 'grad'; }

        if(isset($_POST['ulica']) && !empty($_POST['ulica'])) { $_ulica = trim($_POST['ulica']); }
        else { $_errors[] = 'ulica'; }

        if(isset($_POST['postanskibroj']) && !empty($_POST['postanskibroj'])) { $_postanski = trim($_POST['postanskibroj']); }
        else { $_errors[] = 'postanskibroj'; }

        /*===== PRAVILA PRIVATNOSTI, USLOVI KORIŠTENJA =====*/
        if(!isset($_POST['pravilaprivatnosti'])) { $_errors[] = 'pravilaprivatnosti'; }
        if(!isset($_POST['uslovikoristenja'])) { $_errors[] = 'uslovikoristenja'; }

        /*========================= NEOBAVEZNI PODATCI =========================*/
        /*===== COVID-19 REGULATIVE =====*/
        if(isset($_POST['covid-regulative']))
        {
            foreach($_POST['covid-regulative'] as $key => $value) { $_covidRegulative[] = $value; }
        }

        /*===== RADNO VRIJEME =====*/
        //ponedjeljak
        if((!isset($_POST['ponedjeljakpocetak']) || empty($_POST['ponedjeljakpocetak'])) && (!isset($_POST['ponedjeljakkraj']) || empty($_POST['ponedjeljakkraj']))) {
            $_radnoVrijeme['Ponedjeljak'] = 'neradni dan'; }

        if((isset($_POST['ponedjeljakpocetak']) && !empty($_POST['ponedjeljakpocetak'])) && (isset($_POST['ponedjeljakkraj']) && !empty($_POST['ponedjeljakkraj']))) {
            $_radnoVrijeme['Ponedjeljak'] = trim($_POST['ponedjeljakpocetak']) . ' - ' . trim($_POST['ponedjeljakkraj']); }

        if(empty($_radnoVrijeme['Ponedjeljak'])) { $_errors[] = 'ponedjeljak'; }

        //utorak
        if((!isset($_POST['utorakpocetak']) || empty($_POST['utorakpocetak'])) && (!isset($_POST['utorakkraj']) || empty($_POST['utorakkraj']))) {
            $_radnoVrijeme['Utorak'] = 'neradni dan'; }

        if((isset($_POST['utorakpocetak']) && !empty($_POST['utorakpocetak'])) && (isset($_POST['utorakkraj']) && !empty($_POST['utorakkraj']))) {
            $_radnoVrijeme['Utorak'] = trim($_POST['utorakpocetak']) . ' - ' . trim($_POST['utorakkraj']); }

        if(empty($_radnoVrijeme['Utorak'])) { $_errors[] = 'utorak'; }
    
        //srijeda
        if((!isset($_POST['srijedapocetak']) || empty($_POST['srijedapocetak'])) && (!isset($_POST['srijedakraj']) || empty($_POST['srijedakraj']))) {
            $_radnoVrijeme['Srijeda'] = 'neradni dan'; }

        if((isset($_POST['srijedapocetak']) && !empty($_POST['srijedapocetak'])) && (isset($_POST['srijedakraj']) && !empty($_POST['srijedakraj']))) {
            $_radnoVrijeme['Srijeda'] = trim($_POST['srijedapocetak']) . ' - ' . trim($_POST['srijedakraj']); }

        if(empty($_radnoVrijeme['Srijeda'])) { $_errors[] = 'srijeda'; }
    
        //četvrtak
        if((!isset($_POST['cetvrtakpocetak']) || empty($_POST['cetvrtakpocetak'])) && (!isset($_POST['cetvrtakkraj']) || empty($_POST['cetvrtakkraj']))) {
            $_radnoVrijeme['Četvrtak'] = 'neradni dan'; }

        if((isset($_POST['cetvrtakpocetak']) && !empty($_POST['cetvrtakpocetak'])) && (isset($_POST['cetvrtakkraj']) && !empty($_POST['cetvrtakkraj']))) {
            $_radnoVrijeme['Četvrtak'] = trim($_POST['cetvrtakpocetak']) . ' - ' . trim($_POST['cetvrtakkraj']); }
    
        if(empty($_radnoVrijeme['Četvrtak'])) { $_errors[] = 'cetvrtak'; }

        //petak
        if((!isset($_POST['petakpocetak']) || empty($_POST['petakpocetak'])) && (!isset($_POST['petakkraj']) || empty($_POST['petakkraj']))) {
            $_radnoVrijeme['Petak'] = 'neradni dan'; }

        if((isset($_POST['petakpocetak']) && !empty($_POST['petakpocetak'])) && (isset($_POST['petakkraj']) && !empty($_POST['petakkraj']))) {
            $_radnoVrijeme['Petak'] = trim($_POST['petakpocetak']) . ' - ' . trim($_POST['petakkraj']); }

        if(empty($_radnoVrijeme['Petak'])) { $_errors[] = 'petak'; }

        //subota
        if((!isset($_POST['subotapocetak']) || empty($_POST['subotapocetak'])) && (!isset($_POST['subotakraj']) || empty($_POST['subotakraj']))) {
            $_radnoVrijeme['Subota'] = 'neradni dan'; }

        if((isset($_POST['subotapocetak']) && !empty($_POST['subotapocetak'])) && (isset($_POST['subotakraj']) && !empty($_POST['subotakraj']))) {
            $_radnoVrijeme['Subota'] = trim($_POST['subotapocetak']) . ' - ' . trim($_POST['subotakraj']); }

        if(empty($_radnoVrijeme['Subota'])) { $_errors[] = 'subota'; }

        //nedjelja
        if((!isset($_POST['nedjeljapocetak']) || empty($_POST['nedjeljapocetak'])) && (!isset($_POST['nedjeljakraj']) || empty($_POST['nedjeljakraj']))) {
            $_radnoVrijeme['Nedjelja'] = 'neradni dan'; }

        if((isset($_POST['nedjeljapocetak']) && !empty($_POST['nedjeljapocetak'])) && (isset($_POST['nedjeljakraj']) && !empty($_POST['nedjeljakraj']))) {
            $_radnoVrijeme['Nedjelja'] = trim($_POST['nedjeljapocetak']) . ' - ' . trim($_POST['nedjeljakraj']); }

        if(empty($_radnoVrijeme['Nedjelja'])) { $_errors[] = 'nedjelja'; }

        /*===== FOLDER GALERIJE =====*/
        $_galleryFolder = '/uploads/listinzi/' . str_shuffle(bin2hex($_naziv . random_bytes(6))) . '/';

        if(empty($_errors))
        {
            if($_POST['subscription_plan'] === 'basic')
            {
                $_listingData = array(
                                    "covidRegulative" => $_covidRegulative,
                                    "radnoVrijeme" => $_radnoVrijeme);

                $_galleryData = array(
                                    "putanja" => $_galleryFolder,
                                    "slike" => $_galleryPhotos);

                $_adresa = $_ulica . ', ' . $_grad . ' ' . $_postanski;

                $_galleryData = json_encode($_galleryData, JSON_UNESCAPED_UNICODE);
                $_listingData = json_encode($_listingData, JSON_UNESCAPED_UNICODE);

                try {
                    $sql = "INSERT INTO `listing` (`vlasnik`, `plan`, `naziv`, `kategorija`, `podkategorija`, `kontaktTelefon`, `adresa`, `listingData`, `galleryData`) VALUES ('Ime i prezime', 1, :naziv, :kategorija, 'Test', :kontakt, :adresa, :listingdata, :gallerydata)";

                    $stmt = $pdo->prepare($sql);
                    $stmt->execute(array(
                            ":naziv" => $_naziv,
                            ":kategorija" => $_kategorija,
                            ":kontakt" => $_kontakt,
                            ":adresa" => $_adresa,
                            ":listingdata" => $_listingData,
                            ":gallerydata" => $_galleryData));

                    $sql = "INSERT INTO `gradovi` (`naziv`, `brojObjekata`) VALUES (?, 1) ON DUPLICATE KEY UPDATE `brojObjekata` = brojObjekata + 1";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(1, $_grad);
                    $stmt->execute();

                    $sql = "UPDATE `kategorije` SET `brojObjekata` = brojObjekata + 1 WHERE `naziv` = ?";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(1, $_kategorija);
                    $stmt->execute();

                    $_errors['success'] = 1;
                }
                catch(PDOexception $e) {
                    echo $e->getMessage();
                }
            }
            else
            {
                /*==================== VARIJABLE =========================*/
                $_marker = array();
                $_opsteZnacajke = array();
                $_znacajkeKategorije = array();
                $_galleryPhotos = array();
                $_socijalneMreze = array();

                /*===== MARKER KOORDINATE =====*/
                if((isset($_COOKIE['markerLat']) && !empty($_COOKIE['markerLat'])) && (isset($_COOKIE['markerLng']) && !empty($_COOKIE['markerLng'])))
                {
                    $_marker[0] = $_COOKIE['markerLat'];
                    $_marker[1] = $_COOKIE['markerLng'];
                    unset($_COOKIE['markerLat']);
                    unset($_COOKIE['markerLng']);
                }

                /*===== OPŠTE ZNAČAJKE =====*/
                if(!empty($_POST['opsteznacajke']))
                {
                    foreach($_POST['opsteznacajke'] as $key => $value) { $_opsteZnacajke[] = $value; }
                }

                /*===== SOCIJALNE MREŽE =====*/
                /*if(!empty($_POST['socijalnemreze']))
                {
                    foreach($_POST['socijalnemreze'] as $key => $value) { if(!empty($value)) { $_socijalneMreze[$key] = $value; $_errors[] = $value } }
                }*/

                foreach($_POST['socijalnemreze'] as $key => $value)
                {
                    if(!empty($value))
                    {
                        $_socijalneMreze[$key] = $value;
                    }
                }

                /*===== ZNAČAJKE KATEGORIJE =====*/
                if(!empty($_POST['znacajkekategorije']))
                {
                    foreach($_POST['znacajkekategorije'] as $key => $value) { $_znacajkeKategorije[] = $value; } 
                }

                /*========================= STANDARD PLAN =========================*/
                if($_POST['subscription_plan'] === 'standard')
                {
                    /*===== GALERIJA =====*/
                    if(isset($_POST['passingImages']) && !empty($_POST['passingImages']))
                    {
                        $_passingImages = json_decode($_POST['passingImages'], true);
                        $_countImages = count($_passingImages);

                        if($_countImages > 5) { $_errors[] = 'galleryphotos'; }
                        else
                        {
                            if(!file_exists(dirname(__DIR__, 1) . $_galleryFolder)) {
                                mkdir(dirname(__DIR__, 1) . $_galleryFolder, 0777, true); }

                            foreach($_FILES['galleryphotos']['name'] as $key => $value)
                            {
                                if(in_array($value, $_passingImages))
                                {
                                    $_temp = explode(".", $_FILES['galleryphotos']['name'][$key]);
                                    $_new_file_name = bin2hex(str_shuffle($_FILES['galleryphotos']['name'][$key]));
                                    $_new_file_name = (strlen($_new_file_name) < 16) ? str_pad($_new_file_name, 16, random_bytes(4)) : substr($_new_file_name, 0, 16);
                                    $_new_file_name = $_new_file_name . '.' . end($_temp);
                                    $_galleryPhotos[] = $_new_file_name;
                                    move_uploaded_file($_FILES['galleryphotos']['tmp_name'][$key], dirname(__DIR__, 1) . $_galleryFolder . $_new_file_name);
                                }
                            }
                        }
                    }

                    if(empty($_errors))
                    {
                        $_listingData = array(
                                            "opsteZnacajke" => $_opsteZnacajke,
                                            "covidRegulative" => $_covidRegulative,
                                            "znacajkeKategorije" => $_znacajkeKategorije,
                                            "radnoVrijeme" => $_radnoVrijeme,
                                            "socijalneMreze" => $_socijalneMreze);
                        
                        $_galleryData = array(
                                            "putanja" => $_galleryFolder,
                                            "slike" => $_galleryPhotos);

                        $_adresa = $_ulica . ', ' . $_grad . ' ' . $_postanski;

                        $_listingData = json_encode($_listingData, JSON_UNESCAPED_UNICODE);
                        $_galleryData = json_encode($_galleryData, JSON_UNESCAPED_UNICODE);

                        try {
                            $sql = "INSERT INTO `listing` (`vlasnik`, `plan`, `naziv`, `kategorija`, `podkategorija`, `kontaktTelefon`, `adresa`, `koordinate`, `listingData`, `galleryData`) VALUES ('Ime i prezime', 2, :naziv, :kategorija, 'Test', :kontakt, :adresa, :koordinate, :listingdata, :gallerydata)";
        
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute(array(
                                    ":naziv" => $_naziv,
                                    ":kategorija" => $_kategorija,
                                    ":kontakt" => $_kontakt,
                                    ":adresa" => $_adresa,
                                    ":koordinate" => json_encode($_marker),
                                    ":listingdata" => $_listingData,
                                    ":gallerydata" => $_galleryData));

                            $sql = "INSERT INTO `gradovi` (`naziv`, `brojObjekata`) VALUES (?, 1) ON DUPLICATE KEY UPDATE `brojObjekata` = brojObjekata + 1";
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(1, $_grad);
                            $stmt->execute();

                            $sql = "UPDATE `kategorije` SET `brojObjekata` = brojObjekata + 1 WHERE `naziv` = ?";
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(1, $_kategorija);
                            $stmt->execute();
        
                            $_errors['success'] = 1;
                        }
                        catch(PDOexception $e) {
                            echo $e->getMessage();
                        }
                    }
                }
                else if($_POST['subscription_plan'] === 'premium')
                {
                    /*========================= VARIJABLE =========================*/
                    $_tagovi = array();
                    $_faq = array();

                    /*===== GALERIJA =====*/
                    if(isset($_POST['passingImages']) && !empty($_POST['passingImages']))
                    {
                        $_passingImages = json_decode($_POST['passingImages'], true);
                        $_countImages = count($_passingImages);

                        if($_countImages > 10) { $_errors[] = 'galleryphotos'; }
                        else
                        {
                            if(!file_exists(dirname(__DIR__, 1) . $_galleryFolder)) {
                                mkdir(dirname(__DIR__, 1) . $_galleryFolder, 0777, true); }

                            foreach($_FILES['galleryphotos']['name'] as $key => $value)
                            {
                                if(in_array($value, $_passingImages))
                                {
                                    $_temp = explode(".", $_FILES['galleryphotos']['name'][$key]);
                                    $_new_file_name = bin2hex(str_shuffle($_FILES['galleryphotos']['name'][$key]));
                                    $_new_file_name = (strlen($_new_file_name) < 16) ? str_pad($_new_file_name, 16, random_bytes(4)) : substr($_new_file_name, 0, 16);
                                    $_new_file_name = $_new_file_name . '.' . end($_temp);
                                    $_galleryPhotos[] = $_new_file_name;
                                    move_uploaded_file($_FILES['galleryphotos']['tmp_name'][$key], dirname(__DIR__, 1) . $_galleryFolder . $_new_file_name);
                                }
                            }
                        }
                    }

                    /*===== TAGOVI =====*/
                    if(!empty($_POST['kljucnerijeci']))
                    {
                        foreach(array_column(json_decode($_POST['kljucnerijeci']), 'value') as $key => $value) { $_tagovi[] = $value; }
                    }

                    /*========== ČESTO POSTAVLJENA PITANJA ==========*/
                    foreach($_POST['question'] as $key => $pitanje)
                    {
                        if(!empty($_POST['question'][$key]) && empty($_POST['answer'][$key])) { $_errors[] = 'faq' . $key; continue; }
                        if(!empty($_POST['answer'][$key]) && empty($_POST['question'][$key])) { $_errors[] = 'faq' . $key; continue; }

                        if(!empty($_POST['question'][$key]) && !empty($_POST['answer'][$key])) { $_faq[$pitanje] = $_POST['answer'][$key]; }
                    }

                    if(empty($_errors))
                    {
                        $_listingData = array(
                                            "opsteZnacajke" => $_opsteZnacajke,
                                            "covidRegulative" => $_covidRegulative,
                                            "znacajkeKategorije" => $_znacajkeKategorije,
                                            "radnoVrijeme" => $_radnoVrijeme,
                                            "kljucneRijeci" => $_tagovi,
                                            "FAQ" => $_faq,
                                            "socijalneMreze" => $_socijalneMreze);
                        
                        $_galleryData = array(
                                            "putanja" => $_galleryFolder,
                                            "slike" => $_galleryPhotos);

                        $_adresa = $_ulica . ', ' . $_grad . ' ' . $_postanski;

                        $_listingData = json_encode($_listingData, JSON_UNESCAPED_UNICODE);
                        $_galleryData = json_encode($_galleryData, JSON_UNESCAPED_UNICODE);

                        try {
                            $sql = "INSERT INTO `listing` (`vlasnik`, `plan`, `naziv`, `kategorija`, `podkategorija`, `kontaktTelefon`, `adresa`, `koordinate`, `listingData`, `galleryData`) VALUES ('Ime i prezime', 3, :naziv, :kategorija, 'Test', :kontakt, :adresa, :koordinate, :listingdata, :gallerydata)";
        
                            $stmt = $pdo->prepare($sql);
                            $stmt->execute(array(
                                    ":naziv" => $_naziv,
                                    ":kategorija" => $_kategorija,
                                    ":kontakt" => $_kontakt,
                                    ":adresa" => $_adresa,
                                    ":koordinate" => json_encode($_marker),
                                    ":listingdata" => $_listingData,
                                    ":gallerydata" => $_galleryData));

                            $sql = "INSERT INTO `gradovi` (`naziv`, `brojObjekata`) VALUES (?, 1) ON DUPLICATE KEY UPDATE `brojObjekata` = brojObjekata + 1";
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(1, $_grad);
                            $stmt->execute();

                            $sql = "UPDATE `kategorije` SET `brojObjekata` = brojObjekata + 1 WHERE `naziv` = ?";
                            $stmt = $pdo->prepare($sql);
                            $stmt->bindParam(1, $_kategorija);
                            $stmt->execute();
        
                            $_errors['success'] = 1;
                        }
                        catch(PDOexception $e) {
                            echo $e->getMessage();
                        }
                    }
                }
            }
        }

        echo json_encode($_errors, JSON_UNESCAPED_UNICODE);
    }

?>