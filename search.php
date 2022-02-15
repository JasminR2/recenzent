<?php

    session_start();

    require_once(dirname(__FILE__) . "/config.php");
    require_once(dirname(__FILE__) . "/functions.php");

    $platformname = ucfirst($platforminfo['name']);
    $_currentday = strftime("%u");

    if(!empty($_REQUEST['pretraga']))
    {
        $_term = '%' . trim($_REQUEST['pretraga']) . '%';	

		$sql = "SELECT * FROM listing WHERE `naziv` LIKE ? OR `kategorija` = ? OR `adresa` LIKE ? OR JSON_EXTRACT(listingData, '$.kljucneRijeci') LIKE ? ORDER BY `plan` DESC, `naziv` DESC, `id` DESC";

		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(1, $_term);
		$stmt->bindParam(2, $_REQUEST['pretraga']);
		$stmt->bindParam(3, $_term);
		$stmt->bindParam(4, $_term);
        $stmt->execute();
        
        $_count = $stmt->rowCount();

        while($row = $stmt->fetch()) {
            $_currentStatus = '';
            $_data_arr[] = $row;
            $_listingData = json_decode($row['listingData'], true);

            $i = 0;
            foreach($_listingData['radnoVrijeme'] as $_day => $_workHours) {
                $i++;
                if($i == $_currentday) {
                    if($_workHours != 'neradni dan')
                    {
                        $_radnoVrijeme = explode(" - ", $_workHours);
                        if($_radnoVrijeme[1] == '00:00') { $_radnoVrijeme[1] = '24:00'; }
                        $_openingAt = DateTime::createFromFormat("H:i", $_radnoVrijeme[0]);
                        $_closingAt = DateTime::createFromFormat("H:i", $_radnoVrijeme[1]);
                        $_currentTime = DateTime::createFromFormat("H:i", date("H:i"));
                        if($_currentTime > $_openingAt && $_currentTime < $_closingAt) { $_currentStatus = '<p style="color:green;">Trenutno otvoreno</p>'; }
                        else { $_currentStatus = '<p style="color:red;">Trenutno zatvoreno</p>'; }
                    }
                    else { $_currentStatus = '<p style="color:red;">Trenutno zatvoreno</p>'; }
                }
            }            
            $_data_arr = array_map(function($arr) use ($_currentStatus) { return $arr + ['currentStatus' => $_currentStatus]; }, $_data_arr);
        }

        $stmt = null;

        $title = 'Rezultati pretraživanja - ' . $platformname;
    }
    
    else 
    {
        $sql = "SELECT * FROM listing ORDER BY `plan` DESC, `id` DESC";
        $stmt = $pdo->query($sql);
        $stmt->execute();
        $_count = $stmt->rowCount();
    
        while($row = $stmt->fetch()) {
            $_currentStatus = '';
            $_data_arr[] = $row;
            $_listingData = json_decode($row['listingData'], true);

            $i = 0;
            foreach($_listingData['radnoVrijeme'] as $_day => $_workHours) {
                $i++;
                if($i == $_currentday) {
                    if($_workHours != 'neradni dan')
                    {
                        $_radnoVrijeme = explode(" - ", $_workHours);
                        if($_radnoVrijeme[1] == '00:00') { $_radnoVrijeme[1] = '24:00'; }
                        $_openingAt = DateTime::createFromFormat("H:i", $_radnoVrijeme[0]);
                        $_closingAt = DateTime::createFromFormat("H:i", $_radnoVrijeme[1]);
                        $_currentTime = DateTime::createFromFormat("H:i", date("H:i"));
                        if($_currentTime > $_openingAt && $_currentTime < $_closingAt) { $_currentStatus = '<p style="color:green;">Trenutno otvoreno</p>'; }
                        else { $_currentStatus = '<p style="color:red;">Trenutno zatvoreno</p>'; }
                    }
                    else { $_currentStatus = '<p style="color:red;">Trenutno zatvoreno</p>'; }
                }
            }            
            $_data_arr = array_map(function($arr) use ($_currentStatus) { return $arr + ['currentStatus' => $_currentStatus]; }, $_data_arr);
        }

        $title = 'Pretraga - ' . $platformname;
    }

    if(!empty($_REQUEST['kategorija']) && !empty($_REQUEST['grad']))
    {
        $_kategorija = trim($_REQUEST['kategorija']) . "%";
        $_podkategorija = "%" . trim($_REQUEST['kategorija']) . "%";
        $_grad = "%" . trim($_REQUEST['grad']) . "%";

        $sql = "SELECT * FROM `listing` WHERE `kategorija` = :kat OR `podkategorija` = :podkat AND `adresa` LIKE :grad";        
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
                            ":kat" => $_kategorija,
                            ":podkat" => $_kategorija,
                            ":grad" => $_grad));

        $_count = $stmt->rowCount();

        while($row = $stmt->fetch()) {
            $_currentStatus = '';
            $_data_arr[] = $row;
            $_listingData = json_decode($row['listingData'], true);

            $i = 0;
            foreach($_listingData['radnoVrijeme'] as $_day => $_workHours) {
                $i++;
                if($i == $_currentday) {
                    if($_workHours != 'neradni dan')
                    {
                        $_radnoVrijeme = explode(" - ", $_workHours);
                        if($_radnoVrijeme[1] == '00:00') { $_radnoVrijeme[1] = '24:00'; }
                        $_openingAt = DateTime::createFromFormat("H:i", $_radnoVrijeme[0]);
                        $_closingAt = DateTime::createFromFormat("H:i", $_radnoVrijeme[1]);
                        $_currentTime = DateTime::createFromFormat("H:i", date("H:i"));
                        if($_currentTime > $_openingAt && $_currentTime < $_closingAt) { $_currentStatus = '<p style="color:green;">Trenutno otvoreno</p>'; }
                        else { $_currentStatus = '<p style="color:red;">Trenutno zatvoreno</p>'; }
                    }
                    else { $_currentStatus = '<p style="color:red;">Trenutno zatvoreno</p>'; }
                }
            }            
            $_data_arr = array_map(function($arr) use ($_currentStatus) { return $arr + ['currentStatus' => $_currentStatus]; }, $_data_arr);
        }

        $stmt = null;

        $title = 'Rezultati pretraživanja - ' . $platformname;
    }

    $_markeri = array();
    foreach($_data_arr as $result) {

        if(!empty($result['koordinate']))
        {
            $_galleryData = json_decode($result['galleryData'], true);
            
            if(empty($_galleryData['slike'])) { $_photo = '<img src="images/listing-placeholder-logo.png" />'; }
            else { $_photo = '<img src=".' . $_galleryData['putanja'] . $_galleryData['slike'][0] . '" />'; }

            if($result['prosjecnaOcjena'] == 0) { $_ocjena = '<p>Nema recenzija'; }
            else { $_ocjena = '<span class="material-icons-outlined md-20 md-dark md-inactive">grade</span><p>' . $result['prosjecnaOcjena'] . ' (' . $result['brojRecenzija'] . ' recenzija)'; }

            $_infowindowContent =   '<div class="infoWindow"><div class="thumbnail">' . $_photo . '
                                            <div class="data-body"><a href="listing.php?id=' . $result['id'] . '" class="search-result">' . htmlspecialchars($result['naziv']) . '</a></div>
                                            <div class="data-body" title="Rejting">' . $_ocjena . '</p>&middot;<p>' . $result['podkategorija'] . '</p></div>
                                            <div class="data-body">
                                                <li title="Adresa"><span class="material-icons-outlined md-24 md-dark">location_on</span><p>' . htmlspecialchars($result['adresa']) . '</p></span>
                                                <li title="Kontakt telefon"><span class="material-icons-outlined md-24 md-light">phone_in_talk</span><p>' . htmlspecialchars($result['kontaktTelefon']) . '</p></span>
                                            </div>
                                        </div>
                                        <div class="data-footer">
                                            <div class="data-body">' . $result['currentStatus'] . '</div>
                                        </div>
                                    </div>';
            $_marker = json_decode($result['koordinate']);
            array_push($_markeri, array($result['naziv'], $_marker[0], $_marker[1], $result['id'], $result['adresa'], $result['prosjecnaOcjena'], $_infowindowContent));
        }
    }

?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <?php include(dirname(__FILE__) . "/blocks/header.html"); ?>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">        
        <script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgSJ_TFGri9HLolC_XM2lThsal3sjPAOs"></script>
        <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" />
        <script type="text/javascript" src="js/jquery.ui.touch-punch.min.js"></script>
        <script type="text/javascript">
            var lokacije = [], markeri = [];
        </script>
        <script type="text/javascript" src="js/search.js"></script>
        <title><?php echo $title; ?></title>
    </head>
    <body>

        <?php include(dirname(__FILE__) . "/blocks/nav.php"); ?>
        <?php include(dirname(__FILE__) . "/blocks/mobilenav.php"); ?>

        <section id="search">

            <div class="column">

                <div class="header">

                    <button type="button" class="filled togglefilters" onclick="toggleSearchFilters();">Filtriraj</button>
                
                </div>

                <form id="filter">

                    <button type="button" class="filled togglefilters" onclick="toggleSearchFilters();">Zatvori</button>
                            
                    <div class="filters-group">
                        <span class="filters-name"><p>Kategorije</p></span>

                        <div class="filters-group-dropdown">
                            <?php $_kategorije = listAllCategories(); foreach($_kategorije as $_kat) { ?>

                                <label class="checkbox-custom">
                                    <p><?php echo $_kat ?></p>
                                    <input type="checkbox" name="kategorije[]" value="<?php echo $_kat; ?>">
                                    <span class="checkbox-custom-control"></span>
                                </label>

                            <?php } ?>
                        </div>
                    </div>

                    <div class="filters-group">
                        <span class="filters-name"><p>Gradovi</p></span>

                        <div class="filters-group-dropdown">

                            <?php $_gradovi = listAllCities(); foreach($_gradovi as $_grad) { ?>

                                <label class="checkbox-custom">
                                    <p><?php echo $_grad ?></p>
                                    <input type="checkbox" name="gradovi[]" value="<?php echo $_grad; ?>">
                                    <span class="checkbox-custom-control"></span>
                                </label>

                            <?php } ?>
                        </div>
                    </div>

                    <div class="filters-group">
                        <span class="filters-name"><p>Opšte značajke</p></span>

                        <div class="filters-group-dropdown">

                            <label class="checkbox-custom"><p>Besplatan WiFi</p>
                                <input type="checkbox" name="opste[]" value="Besplatan WiFi">
                                <span class="checkbox-custom-control"></span>
                            </label>

                            <label class="checkbox-custom"><p>Besplatan parking</p>
                                <input type="checkbox" name="opste[]" value="Besplatan parking">
                                <span class="checkbox-custom-control"></span>
                            </label>

                            <label class="checkbox-custom"><p>Kartično plaćanje</p>
                                <input type="checkbox" name="opste[]" value="Kartično plaćanje">
                                <span class="checkbox-custom-control"></span>
                            </label>

                            <label class="checkbox-custom"><p>Pušenje zabranjeno</p>
                                <input type="checkbox" name="opste[]" value="Pušenje zabranjeno">
                                <span class="checkbox-custom-control"></span>
                            </label>

                            <label class="checkbox-custom"><p>Pet friendly</p>
                                <input type="checkbox" name="opste[]" value="Pet friendly">
                                <span class="checkbox-custom-control"></span>
                            </label>

                            <label class="checkbox-custom"><p>Klimatizirano</p>
                                <input type="checkbox" name="opste[]" value="Klimatizirano">
                                <span class="checkbox-custom-control"></span>
                            </label>
                        </div>
                    </div>

                    <div class="filters-group covidregulative">
                        <span class="filters-name"><p>Covid-19 regulative</p></span>

                        <div class="filters-group-dropdown">

                            <label class="checkbox-custom"><p>Maske obavezne</p>
                                <input type="checkbox" name="covid-regulative[]" value="Maske obavezne">
                                <span class="checkbox-custom-control"></span>
                            </label>

                            <label class="checkbox-custom"><p>Potvrda o vakcinaciji</p>
                                <input type="checkbox" name="covid-regulative[]" value="Potvrda o vakcinaciji">
                                <span class="checkbox-custom-control"></span>
                            </label>

                            <label class="checkbox-custom"><p>Osoblje vakcinisano</p>
                                <input type="checkbox" name="covid-regulative[]" value="Osoblje vakcinisano">
                                <span class="checkbox-custom-control"></span>
                            </label>

                            <label class="checkbox-custom"><p>Osoblje nosi maske</p>
                                <input type="checkbox" name="covid-regulative[]" value="Osoblje nosi maske">
                                <span class="checkbox-custom-control"></span>
                            </label>
                        </div>
                    </div>

                    <div class="filters-group">
                        <span class="filters-name"><p>Ostalo</p></span>

                        <div class="filters-group-dropdown">
                            <label class="checkbox-custom"><p>Trenutno otvoreno</p>
                                <input type="checkbox" name="trenutno_otvoreno">
                                <span class="checkbox-custom-control"></span>
                            </label>
                        </div>
                    </div>

                    <div class="filters-group">
                        <span class="filters-name"><p>Ocjena</p></span>

                        <div class="filters-group-dropdown ocjena">
                            <label class="checkbox-custom"><p><i class="fa-solid fa-star fa-fw"></i></p>
                                <input type="checkbox" name="covid-regulative[]" value="Osoblje nosi maske">
                                <span class="checkbox-custom-control"></span>
                            </label>

                            <label class="checkbox-custom"><p><i class="fa-solid fa-star fa-fw"></i><i class="fa-solid fa-star fa-fw"></i></p>
                                <input type="checkbox" name="covid-regulative[]" value="Osoblje nosi maske">
                                <span class="checkbox-custom-control"></span>
                            </label>

                            <label class="checkbox-custom"><p><i class="fa-solid fa-star fa-fw"></i><i class="fa-solid fa-star fa-fw"></i><i class="fa-solid fa-star fa-fw"></i></p>
                                <input type="checkbox" name="covid-regulative[]" value="Osoblje nosi maske">
                                <span class="checkbox-custom-control"></span>
                            </label>

                            <label class="checkbox-custom"><p><i class="fa-solid fa-star fa-fw"></i><i class="fa-solid fa-star fa-fw"></i><i class="fa-solid fa-star fa-fw"></i><i class="fa-solid fa-star fa-fw"></i></p>
                                <input type="checkbox" name="covid-regulative[]" value="Osoblje nosi maske">
                                <span class="checkbox-custom-control"></span>
                            </label>
                        </div>
                    </div>

                    <div class="filters-group">
                        <span class="filters-name"><p>Sortiraj po</p></span>

                        <div class="filters-group-dropdown sortiranje">
                            <p class="filters-value" data-value="najnoviji">Prvo najnoviji</p>
                            <p class="filters-value" data-value="najstariji">Prvo najstariji</p>
                            <p class="filters-value" data-value="ocjenagore">Prvo najbolje ocijenjeni</p>
                            <p class="filters-value" data-value="ocjenadole">Prvo najlošije ocijenjeni</p>
                            <input type="hidden" name="sortiranje" class="search-sortiranje" value="najnoviji" />
                        </div>
                    </div>
                </form>

                <div class="results-container">
                    
                    <?php
                        if(empty($_data_arr)) { echo '<h6 class="pretraga-error">Za traženi pojam nema rezultata.</h6>'; }
                        else
                        {
                            foreach($_data_arr as $result)
                            {
                                $_listingData = json_decode($result['listingData'], true);
                                $_galleryData = json_decode($result['galleryData'], true);
                                $_marker = json_decode($result['koordinate']);

                                if($result['prosjecnaOcjena'] == 0) { $ocjena = '<p>Nema recenzija'; }
                                else { $ocjena = '<span class="material-icons-outlined md-20 md-dark md-inactive">grade</span><p>' . $result['prosjecnaOcjena'] . ' (' . $result['brojRecenzija'] . ' recenzija)'; }

                                echo '<div class="listing">';

                                    echo '<div class="search-thumbnail">';
                                        if(empty($_galleryData['slike'])) { echo '<img src="images/listing-placeholder-logo.png" />'; }
                                        else { echo '<img src=".' . $_galleryData['putanja'] . $_galleryData['slike'][0] . '" />'; }
                                        echo '<div class="labels">
                                                <div class="category"><a href="search.php?kategorija=' . $result['kategorija'] . '" class="search-result-category" title="Pretraga po kategoriji">' . $result['kategorija'] . '</a></div>
                                                <div class="bookmark"><a href="#" title="Spremi listing"><i class="lar la-heart fa-fw"></i> Spremi</a></div>
                                              </div></div>';

                                    echo '<div class="data">';

                                        echo '<div class="data-body"><a href="listing.php?id=' . $result['id'] . '" class="search-result">' . htmlspecialchars($result['naziv']) . '</a></div>';
                                        echo '<div class="data-body" title="Rejting">' . $ocjena . '</p>&middot;<p>' . $result['podkategorija'] . '</p></div>';
                                        echo '<div class="data-info">
                                                <li title="Adresa"><i class="las la-map-marker fa-fw"></i><p>' . htmlspecialchars($result['adresa']) . '</p></span>
                                                <li title="Kontakt telefon"><i class="las la-phone fa-fw"></i><p>' . htmlspecialchars($result['kontaktTelefon']) . '</p></span>
                                              </div>';
                                    echo '</div>';

                                    if(!empty(json_decode($result['koordinate']))) {
                                        echo '<div class="data-footer"><a class="listing-lokacija" data-panto="' . $result['naziv'] . '" href="#searchmap">Pokaži na mapi</a>' . $result['currentStatus'] . '</div>'; }

                                echo '</div>';
                            }
                        }
                    ?>
                </div>
            </div>
            
            <div class="column">
                <div class="map-container"><div id="searchmap"></div></div>
            </div>

                <script>
        
                </script>
        </section>
    </body>

    <footer>

        <script type="text/javascript">

            lokacije = <?php echo json_encode($_markeri); ?>;
            var panto = $("[data-panto]");

            var granice = {
                west: 15.7500260759,
                south: 42.65,
                east: 19.59976,
                north: 45.2337767604,
            };

            var map = new google.maps.Map(document.getElementById("searchmap"), {
                zoom: 10,
                center: new google.maps.LatLng(43.856, 18.413),
                scrollwheel: true,
                mapTypeId: 'hybrid',
                restriction: {
                    latLngBounds: granice,
                    strictBounds: false,
                }
            });

            var marker, i;
            const infoWindow = new google.maps.InfoWindow({ maxWidth: 320, maxHeight: 200 });

            for(i = 0; i < lokacije.length; i++) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(lokacije[i][1], lokacije[i][2]),
                    map: map
                });

                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        infoWindow.close();
                        infoWindow.setContent(lokacije[i][6]);
                        infoWindow.open(map, marker);
                    }
                })(marker, i));

                markeri.push(marker);

                panto.filter(function(){
                    return $(this).data('panto') === lokacije[i][0];
                }).on('click', (function(marker){
                    return function(){
                        map.panTo(marker.getPosition());
                        map.setZoom(17);
                }
                })(marker));

                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                    return function() {
                        map.panTo(marker.getPosition());
                    }
                })(marker, i));
            }

            var markerClusterer = new MarkerClusterer(map, markeri, {
                imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
            });

            function toggleSearchFilters() {
                if($(window).width() < 576) { $("form#filter").slideToggle(); }
                else { $("form#filter").toggle("slide", {direction:'left'}); }
            }

            
            jQuery(document).ready(function() {
                if(jQuery(window).width() > 576)
                {
                    var height = $(window).height() - $("#navigation").outerHeight(true);
                    $(".map-container").css("height", height);
                    $("#search").css("max-height", height);
                    $("form#filter").css("height", height);
                }

                <?php if(isset($_REQUEST['kategorija']) && isset($_REQUEST['grad'])): ?>
                    $('input[type="checkbox"][name="kategorije[]"][value="<?php echo $_REQUEST["kategorija"]; ?>"]').prop("checked", true).trigger("change");
                    $('input[type="checkbox"][name="gradovi[]"][value="<?php echo $_REQUEST["grad"]; ?>"]').prop("checked", true).trigger("change");
                <?php endif; ?>
            });

        </script>

    </footer>
</html>