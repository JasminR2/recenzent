<?php

    session_start();

    if(isset($_SESSION['user_loggedin']) && $_SESSION['user_loggedin'] == true) {
        session_destroy();
    }

    header("Location: index.php");

?>