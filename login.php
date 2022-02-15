<?php

    session_start();

    require_once("config.php");
    
    $platformname = ucfirst($platforminfo['name']);

    $title =  'Prijavite se - ' . $platformname;

    if(isset($_SESSION["user_loggedin"]) && $_SESSION["user_loggedin"] == true) {
        header("location: index.php");
    }

?>

<!DOCTYPE html>
<html>

    <head>
        <?php include "blocks/header.html"; ?>
        <title><?php echo $title; ?></title>
    </head>

    <body>

        <?php include "blocks/nav.php"; ?>
        <?php include "blocks/mobilenav.php"; ?>
        
        <section id="connectpage">

            <div class="container">

                <h1>Prijava</h1>

                <p>Nastavljanjem prihvatate naše uslove korištenja i pravila privatnosti.</p>

                <form id="loginform" class="accountform" method="POST">

                    <div class="inputwrapper" id="email">
                        <input type="email" name="email" placeholder="E-Mail">
                    </div>
                    <div class="inputwrapper" id="lozinka">
                        <input type="password" name="lozinka" placeholder="Lozinka">
                    </div>
                    <div class="inputwrapper" id="captcha">
                        <div class="h-captcha" data-sitekey="10000000-ffff-ffff-ffff-000000000001"></div>
                    </div>
                    <button type="submit" class="filled">Prijava</button>

                </form>

                <p>Novi korisnik? <a href="register.php">Napravite račun.</a></p>

            </div>

            <img src="images/ilustrations/prijava.png" style="width: 450px; height: 450px;">

        </section>

        <?php include "blocks/footer.php"; ?>

    </body>

    <footer>
        <script type="text/javascript">

            jQuery(document).ready(function() {
                
                $("#loginform").submit(function(e) {
                    e.preventDefault();
                    $(".inputwrapper").find("span.error").remove();
                    $(".inputwrapper input").css("border-color", "");

                    $.ajax({
                        type: 'POST',
                        url: 'formvalidation/login.php',
                        data: $("#loginform").serialize(),
                        dataType: 'json',
                        beforeSend: function() {
                            $("#loginform button[type='submit']").html("<i class='fas fa-spinner fa-spin'></i>").prop("disabled", true);
                        },
                        success: function(data) {
                            if(!data.success) {

                                $("#loginform button[type='submit']").html("Prijava").prop("disabled", false);

                                $.each(data, function(field, error) {
                                    $("#" + field + ".inputwrapper").append(error);
                                    $("#" + field + ".inputwrapper input").css("border-color", "red").addClass("incorrect");
                                    
                                });
                            }
                            else {
                                setTimeout(function() {
                                    $("#loginform button[type='submit']").html("prijava uspiješna, redirekcija &emsp; <i class='fas fa-spinner fa-spin'></i>");
                                    setTimeout(function() {
                                        window.location.href = "index.php";
                                    }, 1250);
                                }, 1500);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert(textStatus + ' ' + errorThrown);
                        }
                    })
                })
            })
        </script>
    </footer>

</html>