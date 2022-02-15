<?php

    session_start();

    require_once("config.php");    
    
    $platformname = ucfirst($platforminfo['name']);

    $title =  'Registrujte se - ' . $platformname;

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

                <h1>Registracija</h1>

                <p>Nastavljanjem prihvatate naše uslove korištenja i pravila privatnosti.</p>

                <form id="registerform" class="accountform" method="POST">

                    <div class="inputwrapper" style="width: 47.5%;" id="ime">
                        <input type="text" name="ime" placeholder="Ime">
                    </div>
                    <div class="inputwrapper" style="width: 47.5%;" id="prezime">
                        <input type="text" name="prezime" placeholder="Prezime">
                    </div>
                    <div class="inputwrapper" id="email">
                        <input type="email" name="email" placeholder="E-Mail">
                    </div>
                    <div class="inputwrapper" id="lozinka">
                        <input type="password" name="lozinka" placeholder="Lozinka" style="margin-bottom: 0.5rem;">
                    </div>
                    <div class="inputwrapper" id="potvrdilozinku">
                        <input type="password" name="potvrdilozinku" placeholder="Potvrdite lozinku">
                        <span><p>* Lozinka mora sadržavati najmanje 8 znakova, jedno veliko slovo i jedan broj.</p></span>
                    </div>
                    <div class="inputwrapper" id="captcha">
                        <div class="h-captcha" data-sitekey="10000000-ffff-ffff-ffff-000000000001"></div>
                    </div>
                    <button type="submit" class="filled">Registracija</button>

                </form>

                <p>Imate profil? <a href="login.php">Prijavite se.</a></p>

            </div>

            <img src="images/ilustrations/registracija.png" style="width: 450px; height: 450px;">

        </section>

        <?php include "blocks/footer.php"; ?>

    </body>

    <footer>
        <script type="text/javascript">
            jQuery(document).ready(function() {

                $("#registerform").submit(function(e) {
                    e.preventDefault();
                    $(".inputwrapper").find("span.error").remove();
                    $(".inputwrapper input").css("border-color", "");

                    $.ajax({
                        type: 'POST',
                        url: 'formvalidation/register.php',
                        data: $("#registerform").serialize(),
                        dataType: 'json',
                        beforeSend: function() {
                            $("#registerform button[type='submit']").html("<i class='fas fa-spinner fa-spin'></i>").prop("disabled", true);
                        },
                        success: function(data) {

                            if(!data.success) {
                                $("#registerform button[type='submit']").html("Registracija").prop("disabled", false);
                                $.each(data, function(field, error) {
                                    $("#" + field + ".inputwrapper").append(error);
                                    $("#" + field + ".inputwrapper input").css("border-color", "red").addClass("incorrect");
                                    
                                });
                            }
                            else {
                                setTimeout(function() {
                                    $("#registerform button[type='submit']").html("registracija uspiješna, redirekcija &emsp; <i class='fas fa-spinner fa-spin'></i>");
                                    setTimeout(function() {
                                        window.location.href = "index.php";
                                    }, 1250);
                                }, 1500);
                            }
                        },                        
                        error: function(jqXHR, textStatus, errorThrown) {
                            alert(textStatus + ' ' + errorThrown);
                        }
                    });
                });

                $("body").on("click", ".inputwrapper input.incorrect", function() {
                    $(this).css("border-color", "").removeClass("incorrect");
                });

            })
        </script>
    </footer>

</html>