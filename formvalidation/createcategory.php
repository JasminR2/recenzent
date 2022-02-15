<?php

    require_once("../config.php");

    session_start();

    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $_naziv_kategorije = trim($_POST['nazivkategorije']);
        $_znacajke = array();

        foreach($_POST['znacajkekategorije'] as $key => $value)
        {
            if(isset($value) && !empty($value))
            {
                $_znacajke[] = $value;
            }
        }

        $_znacajke = json_encode($_znacajke, JSON_UNESCAPED_UNICODE);

        $stmt = $pdo->prepare("INSERT INTO `kategorije` (`naziv`, `znacajke`) VALUES (:naziv, :znacajke)");
        $stmt->bindParam(":naziv", $_naziv_kategorije);
        $stmt->bindParam(":znacajke", $_znacajke);
        $stmt->execute();
    } 

?>
