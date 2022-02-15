<?php

    require_once(dirname(__DIR__) . "/config.php");

    header("Content-Type: application/json");

    $_email = $_password = '';
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

    if($responseData->success === false) { $_errors['captcha'][] = '<span class="error"><span class="error"><p style="color: red;">* obavezno</p></span></span>'; }

    if(isset($_POST['email']) && !empty($_POST['email'])) { $_email = strip_tags(trim($_POST['email'])); }
    else { $_errors['email'][] = '<span class="error"><p style="color: red;">* obavezno</p></span>'; }

    if(isset($_POST['lozinka']) && !empty($_POST['lozinka'])) { $_password = trim($_POST['lozinka']); }
    else { $_errors['lozinka'][] = '<span class="error"><p style="color: red;">* obavezno</p></span>'; }

    if(empty($_errors))
    {
        try {

            $sql = "SELECT `id`, `ime`, `prezime`, `email`, `lozinka` FROM `korisnici` WHERE `email` = :email";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(":email", $_email);
            $stmt->execute();

            $count = $stmt->rowCount();

            if($count > 0)
            {
                $stmt->bindColumn("id", $_id);
                $stmt->bindColumn("ime", $_name);
                $stmt->bindColumn("prezime", $_lastname);
                $stmt->bindColumn("email", $_email);
                $stmt->bindColumn("lozinka", $_hashed_password);
                if($stmt->fetch()) {
                    if(password_verify($_password, $_hashed_password))
                    {
                        session_start();
                        $_SESSION["user_id"] = $_id;
                        $_SESSION["user_fullname"] = 'Ime i prezime';
                        /*$_SESSION["user_name"] = $_name;
                        $_SESSION["user_lastname"] = $_lastname;*/
                        $_SESSION["user_loggedin"] = true;
                        $_errors["success"] = 1;
                    }
                    else {
                        $_errors['lozinka'][] = '<span class="error"><p style="color: red;">* pogrešna lozinka</p></span>';
                    }
                }
            }
            else {
                $_errors['email'][] = '<span class="error"><p style="color: red;">* račun sa tim emailom ne postoji</p></span>';
            }
        }
        catch(PDOexception $e) {
            echo $e->getMessage();
        }
    }

    echo json_encode($_errors, JSON_UNESCAPED_UNICODE);
?>