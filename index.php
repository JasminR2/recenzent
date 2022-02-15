<?php
  
    session_start();

    require_once("config.php");
    include("functions.php");

    $sql = "SELECT COUNT(*) FROM listing";
    $count = $pdo->query($sql)->fetchColumn();

    $platformname = ucfirst($platforminfo['name']);

    $title =  'Pronađite lokalne biznise - ' . $platformname;

?>

<!DOCTYPE html>
<html>

    <head>
        <?php include "blocks/header.html"; ?>
        <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css" />
        <title><?php echo $title; ?></title>
    </head>

    <body>

        <?php include "blocks/nav.php"; ?>
        <?php include "blocks/mobilenav.php"; ?>

        <section id="frontpage-search">

            <div class="header">
                <h1>Istražite i otkrijte</h1>
                <h5>Pronađite nova zanimljiva mjesta!</h5>
            </div>

            <form id="frontpage" action="search.php">

                <div class="inputwrapper">
                    <i class="las la-search fa-fw search"></i>
                    <input type="text" name="kategorija" class="kategorije-picker" autocomplete="off" placeholder="Šta tražite? (npr. restorani)">
                    <div class="ajax-kategorije"></div>
                </div>

                <div class="inputwrapper">
                    <i class="las la-map-marker fa-fw search"></i>
                    <input type="text" name="grad" class="gradovi-picker" autocomplete="off" placeholder="U kojem gradu tražite? (npr. Sarajevo)">
                    <div class="ajax-gradovi"></div>
                </div>

                <button type="submit" class="filled">Traži <?php echo $count ?> rezultata<span class="material-icons-outlined md-20">chevron_right</span></button>

            </form>

        </section>

        <?php include "blocks/footer.php"; ?>

    </body>

    <footer>
        <script type="text/javascript">
            var backgrounds = ["search-bg.jpeg", "search-bg2.jpg", "search-bg3.jpeg"];
            jQuery("#frontpage-search").css({ 'background' : 'linear-gradient(0deg, rgba(0, 0, 0, 0.75), rgba(0, 0, 0, 0.75)), url("./images/' + backgrounds[Math.floor(Math.random() * backgrounds.length)] + '") center center no-repeat', 'background-size' : 'cover'});

            jQuery(document).ready(function() {

                $(document).on("click", function(e) {
                    if($(".ajax-kategorije").css("display") == 'block' && e.target.classname != 'ajax-kategorije') {
                        $(".ajax-kategorije").hide();
                        $("input.kategorije-picker").attr("style", "border-bottom-left-radius: .25rem; border-bottom-color: var(--bg-primary);").css("border-bottom-right-radius", "");
                    }
                    if($(".ajax-gradovi").css("display") == 'block' && e.target.classname != 'ajax-gradovi') {
                        $(".ajax-gradovi").hide();
                        $("input.gradovi-picker").attr("style", "border-bottom-color: var(--bg-primary);").css({ "border-bottom-right-radius" : "", "border-bottom-left-radius" : "" });
                    }
                });

                $("input.kategorije-picker").on("keyup touchend", function() {
                    var val = $(this).val();
                    if($(this).length > 0)
                    {
                        $.ajax({

                            type: 'GET',
                            url: 'formvalidation/frontsearch.php',
                            data: { 'funkcija' : 'populateDropdowns', 'kategorija' : val },
                            success: function(data) {
                                $(".ajax-kategorije").css("display", "block").html(data);
                                $("input.kategorije-picker").attr("style", "border-bottom-left-radius: 0 !important; border-bottom-right-radius: 0 !important; border-bottom-color: var(--bg-secondary);");
                            }

                        });
                    }
                });

                $("input.gradovi-picker").on("keyup touchend", function() {
                    var val = $(this).val();
                    if($(this).length > 0)
                    {
                        $.ajax({

                            type: 'GET',
                            url: 'formvalidation/frontsearch.php',
                            data: { 'funkcija' : 'populateDropdowns', 'grad' : val },
                            success: function(data) {
                                $(".ajax-gradovi").css("display", "block").html(data);
                                $("input.gradovi-picker").attr("style", "border-bottom-left-radius: 0 !important; border-bottom-right-radius: 0 !important; border-bottom-color: var(--bg-secondary);");
                            }

                        });
                    }
                });

                var touchmoved;
                $("body").on("mousedown touchend", ".ajax-kategorije p", function() {
                    if(touchmoved != true)
                    {
                        var val = $(this).text();
                        $("input.kategorije-picker").attr("style", "border-bottom-left-radius: .25rem; border-bottom-color: var(--bg-primary);").css("border-bottom-right-radius", "").val(val);
                        $(".ajax-kategorije").css("display", "none");
                        touchmoved = undefined;
                    }
                }).on('touchmove', function(e){
                    touchmoved = true;
                }).on('touchstart', function(){
                    touchmoved = false;
                });

                $("body").on("mousedown touchend", ".ajax-gradovi p", function() {
                    if(touchmoved != true)
                    {
                        var val = $(this).text();
                        $("input.gradovi-picker").attr("style", "border-bottom-color: var(--bg-primary);").val(val);
                        $(".ajax-gradovi").css("display", "none");
                        touchmoved = undefined;
                    }
                }).on('touchmove', function(e){
                    touchmoved = true;
                }).on('touchstart', function(){
                    touchmoved = false;
                });

                $("input.kategorije-picker, input.gradovi-picker").on("focusout", function() {
                    var kat = $("input.kategorije-picker").val();
                    var grad = $("input.gradovi-picker").val();

                    $.ajax({
                        type: 'GET',
                        url: 'formvalidation/frontsearch.php',
                        data: { 'funkcija': 'countForFront', 'frontpage-kat' : kat, 'frontpage-grad' : grad },
                        beforeSend: function() {
                            $("form#frontpage button").html("<i class='fas fa-spinner fa-spin'></i>").prop("disabled", true);
                        },
                        success: function(data) {
                            $("form#frontpage button").html(data).prop("disabled", false);
                            $(".ajax-kategorije, .ajax-gradovi").hide();
                        }
                    });

                });

            });
        
        </script>
    </footer>

</html>