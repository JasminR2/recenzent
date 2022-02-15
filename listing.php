<?php
  
    session_start();

    require_once("config.php");

    if(!empty($_GET['id']))
    {
        $_currentDay = strftime("%u");
        $i = 0;

        $sql = "SELECT * FROM listing WHERE id = ?";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $_GET['id']);
        $stmt->execute();

        while($row = $stmt->fetch()) {
            $_data_arr = $row;
        }

    }

?>

<!DOCTYPE html>
<html>

    <head>
        <?php
            include "blocks/header.html";
            if(!empty($_data_arr['koordinate'])) { echo '<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgSJ_TFGri9HLolC_XM2lThsal3sjPAOs"></script>'; } 
            echo '<title>' . $_data_arr['naziv'] . ' - ' . $platforminfo['name'] . '</title>';
        ?>

        <link rel="stylesheet" type="text/css" href="styles/slick.css" />
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" />
        <script type="text/javascript" src="js/slick.min.js"></script>
    </head>

    <body>

        <?php include "blocks/nav.php"; ?>
        <?php include "blocks/mobilenav.php"; ?>

        <?php

            if(empty($_GET['id']) || empty($_data_arr)) { include "blocks/404.html"; }
            else
            {
                $_listing_data = json_decode($_data_arr['listingData'], true);
                $_gallery_data = json_decode($_data_arr['galleryData'], true);
                //echo '<pre>'; print_r($_data_arr); echo '</pre>';

                if(!empty($_gallery_data['slike']))
                {
                    echo '<div class="listing_column gallery">';

                    foreach($_gallery_data['slike'] as $image)
                    {
                        echo '<div class="listing_gallery_image"><img src=".' . $_gallery_data['putanja'] . $image . '" /></div>';
                    }

                    echo '</div>';

                }
        ?>

            <div id="images_modal">

                <div class="images_modal_header">

                    <span class="images_modal_counter"></span>

                    <div class="images_modal_buttons">

                        <span class="close_modal"><i class="fa-solid fa-xmark fa-fw"></i></span>

                    </div>

                </div>

                <div class="images_modal_content"></div>

            </div>

            <style>

                #images_modal {
                    display: none;
                    flex-direction: column;
                    justify-content: center;
                    align-items: center;
                    position: fixed;
                    top: 0; left: 0;
                    width: 100%;
                    height: 100%;
                    background-color: rgba(0, 0, 0, .9);
                    z-index: 1001;
                }

                .images_modal_header {
                    position: absolute;
                    top: 0; left: 0;
                    display: flex;
                    flex-flow: row nowrap;
                    justify-content: space-between;
                    align-items: center;
                    width: 100%;
                }

                .images_modal_buttons {
                    display: flex;
                    column-gap: 2rem;
                    padding: 1rem;
                    font-size: 1.375rem;
                    color: var(--bg-secondary);
                }

                .images_modal_counter p {
                    padding: 1rem;
                    font-size: 1.375rem;
                    color: var(--bg-primary);
                }

                .images_modal_buttons * {
                    cursor: pointer;
                    color: var(--bg-secondary);
                }

                .images_modal_buttons *:hover {
                    color: var(--bg-primary);
                }

                .images_modal_content { display: flex; flex-wrap: wrap; justify-content: center; align-items: center; width: 60%; }
                .images_modal_content .slick-prev { position: absolute; left: -75px; }
                .images_modal_content .slick-next { position: absolute; right: -75px; }
                .images_modal_content .slick-track { display: flex; align-items: center; }
                .images_modal_content button.slider-arrows { opacity: 1; }
                .images_modal_content .slick-disabled { display: none !important; pointer-events: none;}

                .images_modal_content img { display: block; order: 2; max-width: 100%; height: auto; margin: auto; }

                @media screen and (max-width: 425px) {
                    .images_modal_content { width: 100%; }
                    .images_modal_content .slick-prev { bottom: -25%; left: 15px; }
                    .images_modal_content .slick-next { bottom: -25%; right: 15px; }
                }

            </style>

            <div id="listingInfo">

                <div class="listing_main">

                    <div class="listing_mainHeader">

                        <div class="listing_headerData">

                            <h3 style="font-family: Varela Round;"><?php echo $_data_arr['naziv']; ?></h3>

                            <div class="listing_meta">

                                <?php
                                    if($_data_arr['brojRecenzija'] == 0) { echo '<p class="listing_reviews">Nema recenzija</p>'; }
                                    else
                                    {
                                        echo '<p class="listing_reviews"><i class="fa-regular fa-star fa-fw"></i>' . $_data_arr['prosjecnaOcjena'] . ' (' . $_data_arr['brojRecenzija'] . ' recenzija)</p>';
                                    }

                                    echo '<p>' . $_data_arr['kategorija'] . '</p>';
                                ?>

                            </div>

                        </div>

                        <?php

                            if(isset($_SESSION['user_loggedin']) && $_SESSION['user_loggedin'] == true)
                            {

                                echo 
                                    '<div class="listing_headerButtons">
                                    
                                        <button type="button" class="filled"><i class="lar la-heart fa-fw" style="margin-right: .375rem;"></i>Spremi</button>

                                        <button type="button" class="filled"><i class="lar la-flag fa-fw" style="margin-right: .375rem;"></i>Prijavi</button>

                                    </div>';
                            }
                        ?>

                    </div>

                    <div class="listing_column about">

                        <div class="listing_columnHeader">

                            <h5>Opis</h5>

                            <?php

                                if(isset($_SESSION['user_loggedin']) && $_SESSION['user_fullname'] == $_data_arr['vlasnik'])
                                {
                                    echo '<i class="las la-edit" title="Uredi"></i>';
                                }

                            ?>

                        </div>

                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris odio nibh, scelerisque nec metus sagittis, hendrerit pretium sapien. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Pellentesque eu consequat tortor, rhoncus lacinia massa. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent convallis erat non ligula faucibus, in faucibus orci lobortis. Etiam ac sagittis est. Praesent pretium libero a purus pellentesque, non sagittis nibh ullamcorper. Quisque bibendum metus sed metus sollicitudin, at porttitor erat fringilla. Fusce vel lacus nec leo congue tristique.</p>

                    </div>

                    <?php

                        if(!empty($_listing_data['opsteZnacajke']) || !empty($_listing_data['znacajkeKategorije']))
                        {

                            echo
                                '<div class="listing_column">

                                <div class="listing_columnHeader">

                                    <h5>Značajke</h5>';

                                    if(isset($_SESSION['user_loggedin']) && $_SESSION['user_fullname'] == $_data_arr['vlasnik'])
                                    {
                                        echo '<i class="las la-edit" title="Uredi"></i>';
                                    }

                            echo
                                '</div>

                                    <div class="amenities">';

                                    foreach($_listing_data['opsteZnacajke'] as $_amenity)
                                    {
                                        echo '<p class="amenity">' . $_amenity . '</p>';
                                    }

                                    foreach($_listing_data['znacajkeKategorije'] as $_amenity)
                                    {
                                        echo '<p class="amenity">' . $_amenity . '</p>';
                                    }

                            echo
                                    '</div>
                                </div>';

                        }

                        if(!empty($_listing_data['covidRegulative']))
                        {

                            echo
                                '<div class="listing_column">

                                <div class="listing_columnHeader">
                                    
                                    <h5>Covid-19 regulative</h5>';

                                    if(isset($_SESSION['user_loggedin']) && $_SESSION['user_fullname'] == $_data_arr['vlasnik'])
                                    {
                                        echo '<i class="las la-edit" title="Uredi"></i>';
                                    }

                            echo
                                '</div>

                                    <div class="amenities">';

                                    foreach($_listing_data['covidRegulative'] as $_amenity)
                                    {
                                        echo '<p class="amenity">' . $_amenity . '</p>';
                                    }

                            echo
                                    '</div>
                                </div>';

                        }

                        if(!empty($_listing_data['FAQ']))
                        {

                            echo 
                                '<div class="listing_column">

                                <div class="listing_columnHeader">

                                    <h5>Često postavljena pitanja</h5>';

                                    if(isset($_SESSION['user_loggedin']) && $_SESSION['user_fullname'] == $_data_arr['vlasnik'])
                                    {
                                        echo '<i class="las la-edit" title="Uredi"></i>';
                                    }

                            echo
                                '</div>

                                    <div class="faq">';

                                    foreach($_listing_data['FAQ'] as $question => $answer)
                                    {
                                        echo '<div class="listing_questionwrapper"><div class="listing_question"><p>' . $question . '?</p><i class="las la-plus"></i></div>';
                                        echo '<div class="listing_answer"><p>' . $answer . '.</p></div></div>';
                                    }

                            echo '</div></div>';
                        }

                        echo
                            '<div class="listing_column openingHours">

                            <div class="listing_columnHeader">

                                <h5>Radno vrijeme</h5>';

                                if(isset($_SESSION['user_loggedin']) && $_SESSION['user_fullname'] == $_data_arr['vlasnik'])
                                {
                                    echo '<i class="las la-edit" title="Uredi"></i>';
                                }

                        echo
                            '</div>
                            
                                <div class="openingHours_list">';

                                foreach($_listing_data['radnoVrijeme'] as $day => $time)
                                {
                                    $i++;
                                    if($i == $_currentDay) { echo '<div class="openingHours_dayWrapper" style="font-weight: bold;"><p>' . $day . '</p>'; }
                                    else { echo '<div class="openingHours_dayWrapper" ><p>' . $day . '</p>'; }
                                    if($time != 'neradni dan')
                                    {
                                        $_radnoVrijeme = explode(" - ", $time);
                                        if($_radnoVrijeme[1] == '00:00') { $_radnoVrijeme[1] = '24:00'; }
                                        echo '<p>' . $_radnoVrijeme[0] . ' - ' . $_radnoVrijeme[1] . '</p></div>';
                                    }
                                    else { echo '<p>' . $time . '</p></div>'; }
                                }

                        echo
                                '</div>
                            </div>';
                    
                    ?>

                    <div class="listing_reviews">

                        <h5>Recenzije</h5>

                    </div>

                </div>

                <div class="listing_sidepanel">

                    <div class="listing_summary">

                        <h5>Informacije</h5>

                        <?php

                        if(!empty($_data_arr['koordinate']))
                        {
                            echo '<div id="listing_littleMap"></div>';
                        }

                        if(!empty($_data_arr['kontaktTelefon']))
                        {
                            echo 
                                '<span>
                                    <p>Kontakt telefon:</p>
                                    <p>+' . $_data_arr['kontaktTelefon'] . '</p>
                                </span>';
                        }

                        echo 
                            '<span>
                                <p>Adresa:</p>
                                <p style="text-align: right;">' . $_data_arr['adresa'] . '</p>
                            </span>';

                        echo '<hr />';

                        echo 
                            '
                            <div class="listing_columnHeader">
                                <span style="justify-content: flex-start;">
                                    <i class="las la-clock fa-fw" style="margin-right: .375rem;"></i>
                                    <h5 style="margin: 0; text-transform: none;">Radno vrijeme</h5>
                                </span>';

                                if(isset($_SESSION['user_loggedin']) && $_SESSION['user_fullname'] == $_data_arr['vlasnik'])
                                {
                                    echo '<i class="las la-edit" title="Uredi"></i>';
                                }

                        echo '
                            </div>';

                        foreach($_listing_data['radnoVrijeme'] as $day => $time)
                        {
                            $i++;
                            if($i == $_currentDay) { echo '<span style="font-weight: bold;"><p>' . $day . '</p>'; }
                            else { echo '<span><p>' . $day . '</p>'; }
                            if($time != 'neradni dan')
                            {
                                $_radnoVrijeme = explode(" - ", $time);
                                if($_radnoVrijeme[1] == '00:00') { $_radnoVrijeme[1] = '24:00'; }
                                echo '<p>' . $_radnoVrijeme[0] . ' - ' . $_radnoVrijeme[1] . '</p></span>';
                            }
                            else { echo '<p>' . $time . '</p></span>'; }
                        }

                        ?>

                        <hr />

                    </div>

                    <!--<h5>Također pogledajte i...</h5>-->

                </div>
            
            </div>

        <?php
            
            }

        ?>

        <?php include "blocks/footer.php"; ?>

    </body>

    <footer>

        <script type="text/javascript">

            jQuery(document).ready(function() {

                $(".listing_question").on("click", function() {
                    $(this).next(".listing_answer").slideToggle();
                    $("i", this).toggleClass("la-plus la-minus");
                });

                $(".listing_column.gallery").slick({
                    infinite: true,
                    slidesToShow: 3,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 5000,
                    centerMode: true,
                    prevArrow: '<button type="button" class="slick-prev slider-arrows"><i class="fa-solid fa-chevron-left fa-fw"></i></button>',
                    nextArrow: '<button type="button" class="slick-next slider-arrows"><i class="fa-solid fa-chevron-right fa-fw"></i></button>',
                    responsive: [
                        {
                            breakpoint: 426,
                            settings:
                            {
                                slidesToShow: 1,
                                centerMode: false
                            }
                        }
                    ]
                });

                $("body").on("click", ".listing_column.gallery img", function() {
                    var thissrc = $(this).attr("src");
                    var src, i = 0;
                    var numb = <?php echo count($_gallery_data['slike']); ?>;

                    $("#images_modal").css("display", "flex").hide().fadeIn();
                    $(".images_modal_content").html('<img src="' + thissrc + '" />');
                    $(".images_modal_counter").html("<p><?php echo $_data_arr['naziv']; ?></p>");
                    $(".listing_column.gallery").slick("slickPause");

                    $(".listing_column.gallery img").each(function() {
                        i++;
                        if(i <= numb)
                        {
                            src = $(this).attr("src");
                            if(src != thissrc) { $(".images_modal_content").append('<img src="' + src + '" />'); }
                        }
                    });

                    $(".images_modal_content").slick({
                        infinite: false,
                        centerMode: 1,
                        fade: true,
                        cssEase: 'linear',
                        prevArrow: '<button type="button" class="slick-prev slider-arrows"><i class="fa-solid fa-chevron-left fa-fw"></i></button>',
                        nextArrow: '<button type="button" class="slick-next slider-arrows"><i class="fa-solid fa-chevron-right fa-fw"></i></button>'
                    });
                });

                $(".images_modal_buttons .close_modal").on("click", function() {
                    $("#images_modal").fadeOut();
                    $(".images_modal_content").slick('unslick');
                    $(".images_modal_content").empty();
                    $(".listing_column.gallery").slick("slickPlay");
                });
            });

        </script>

        <?php

            if(!empty($_data_arr['koordinate']))
            {

        ?>

        <script type="text/javascript">

            var markerCoord = <?php echo $_data_arr['koordinate']; ?>

            var map = new google.maps.Map(document.getElementById("listing_littleMap"), {
                zoom: 17,
                center: new google.maps.LatLng(markerCoord[0], markerCoord[1]),
                mapTypeId: 'hybrid'
            });

            new google.maps.Marker({
                position: new google.maps.LatLng(markerCoord[0], markerCoord[1]),
                map
            });

        </script>

        <?php

            }
        
        ?>

    </footer>

</html>