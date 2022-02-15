<?php

    require_once("config.php");

    function listAllCategories()
    {
        global $pdo;

        $stmt = $pdo->query("SELECT `naziv` FROM `kategorije`");        
        $kategorije = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $kategorije[] = $row['naziv'];
        }

        return $kategorije;
    }

    function listAllCities()
    {
        global $pdo;

        $stmt = $pdo->query("SELECT `naziv` FROM `gradovi`");        
        $gradovi = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $gradovi[] = $row['naziv'];
        }

        return $gradovi;
    }

    function listAllFeatures($kategorija)
    {
        global $pdo;

        $stmt = $pdo->prepare("SELECT `znacajke` FROM `kategorije` WHERE `naziv` = :naziv");
        $stmt->bindParam(":naziv", $kategorija, PDO::PARAM_STR);
        $stmt->execute();
        $data_arr = array();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $data_arr = json_decode($row['znacajke'], true);
        }
        return $data_arr;

    }
?>