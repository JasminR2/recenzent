<?php

    header('Content-Type: application/json');

    require_once("../config.php");

    if(!empty($_REQUEST['kategorija']))
    {

        $stmt = $pdo->prepare("SELECT `znacajke` FROM `kategorije` WHERE `naziv` = :naziv");

        $stmt->bindParam(":naziv", $_REQUEST['kategorija'], PDO::PARAM_STR);
        $stmt->execute();
        $data_arr = array();

        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $data_arr[] = json_decode($row['znacajke'], true);
        }

        echo json_encode($data_arr, JSON_UNESCAPED_UNICODE);

    }
?>