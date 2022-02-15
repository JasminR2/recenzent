<?php

    require_once(dirname(__DIR__) . "/config.php");

    header("Content-Type: application/json");

    $_name = $_lastname = $_email = $_password = '';
    $_errors = array();

    $data = array(
        'secret' => "0x0000000000000000000000000000000000000000",
        'response' => $_POST['h-captcha-response']
    );
    $verify = curl_init();
    curl_setopt($verify, CURLOPT_URL, "https://hcaptcha.com/siteverify");
    curl_setopt($verify, CURLOPT_POST, true);
    curl_setopt($verify, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($verify, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($verify);

    $responseData = json_decode($response);

    if($responseData->success === false) { $_errors['captcha'][] = '<span class="error"><p style="color: red;">* obavezno</p></span>'; }

    if(isset($_POST['ime']) && !empty($_POST['ime'])) {
        $_name = strip_tags(trim($_POST['ime']));
        if(!preg_match("/^[\p{L}\s]+$/u", $_name)) {
            $_errors['ime'][] = '<span class="error"><p style="color: red;">* samo slova</p></span>';
        }
    }
    else {
        $_errors['ime'][] = '<span class="error"><p style="color: red;">* obavezno</p></span>';
    }

    if(isset($_POST['prezime']) && !empty($_POST['prezime'])) {
        $_lastname = strip_tags(trim($_POST['prezime']));
        if(!preg_match("/^[\p{L}\s]+$/u", $_lastname)) {
            $_errors['prezime'][] = '<span class="error"><p style="color: red;">* samo slova</p></span>';
        }
    }
    else {
        $_errors['prezime'][] = '<span class="error"><p style="color: red;">* obavezno</p></span>';
    }


    if(isset($_POST['email']) && !empty($_POST['email'])) {
        $param_email = '';
        $param_email = strip_tags($_POST['email']);

        $sql = 'SELECT * FROM `korisnici` WHERE `email` = ?';

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $param_email);
        $stmt->execute();

        $count = $stmt->rowCount();

        if($count > 0) {
            $_errors['email'][] = '<span class="error"><p style="color: red">* već postoji račun sa tim emailom</p></span>';
        }

        else {
            $_email = strip_tags(trim($_POST['email']));
        }
    }
    else {
        $_errors['email'][] = '<span class="error"><p style="color: red;">* obavezno</p></span>';
    }

    if(isset($_POST['lozinka']) && !empty($_POST['lozinka'])) {
        $_password = trim($_POST['lozinka']);
        $velikaslova = preg_match('@[A-Z]@', $_password);
        $brojevi = preg_match('@[0-9]@', $_password);
        if(strlen($_password) < 8 || !$velikaslova || !$brojevi) {
            $_errors['lozinka'][] = '<span class="error"><p style="color: red;">* lozinka mora sadržavati najmanje 8 znakova, jedno veliko slovo i jedan broj.</p></span>';
        }
    }
    else {
        $_errors['lozinka'][] = '<span class="error"><p style="color: red;">* obavezno</p></span>';
    }

    if(isset($_POST['potvrdilozinku']) && !empty($_POST['potvrdilozinku'])) {
        if(trim($_POST['potvrdilozinku']) != $_password) {
            $_errors['potvrdilozinku'][] = '<span class="error"><p style="color: red;">* lozinke se ne podudaraju</p></span>';
        }
    }
    else {
        $_errors['potvrdilozinku'][] = '<span class="error"><p style="color: red;">* obavezno</p></span>';
    }

    if(empty($_errors)) {
        try {
            
            $sql = 'INSERT INTO `korisnici` (`id`, `ime`, `prezime`, `email`, `lozinka`) VALUES (:id, :ime, :prezime, :email, :lozinka)';

            $stmt = $pdo->prepare($sql);
            $stmt->execute(array(
                                ":id" => bin2hex(random_bytes(8)),
                                ":ime" => $_name,
                                ":prezime" => $_lastname,
                                ":email" => $_email,
                                ":lozinka" => password_hash($_password, PASSWORD_BCRYPT, ["cost" => 11])));

            $_errors['success'] = 1;

        }
        catch(PDOexception $e) {
            echo $e->getMessage();
        }
    }

    echo json_encode($_errors, JSON_UNESCAPED_UNICODE);
?>