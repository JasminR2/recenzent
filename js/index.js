function checkViewport() {
    if(jQuery(window).width() < 576) {
        var offset = jQuery("#mobilenavigation > .mobilenav-header").outerHeight(true);
        jQuery("body").css("padding-top", offset);
    }
    else {
        var offset = jQuery("#navigation").outerHeight(true);
        jQuery("body").css("padding-top", offset);
    }
}

jQuery(document).ready(function() {
    
    checkViewport();

    $(window).resize(function() {
        var vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', `${vh}px`);
        checkViewport();
    });

    /*========================= MOBILE NAVIGATION =========================*/
    $("#mobilenavigation button.navopener").on("click", function() {
        if(!$("#mobilenavigation > .container").hasClass("active")) {
            $('span', this).text('close');
            $("#mobilenavigation > .container").css("display", "flex").hide().slideDown("slow").addClass("active");
            $("html, body").css("overflow", "hidden");
        }
        else {
            $('span', this).html('menu');
            $("#mobilenavigation > .container").slideUp("slow").removeClass("active");
            $("html, body").css("overflow", "visible");
        }
    });

    /*========================= SEARCH ENGINE =========================*/
    $(".searchbar form input.navigation-search").on("keyup change", function() {
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".navigation-search-results");
        if(inputVal.length)
        {
            $.ajax({
                type: 'GET',
                url: './formvalidation/frontsearch.php',
                data: { 'funkcija' : 'populateDropdowns', 'pretraga': inputVal },
                success: function(data) {
                    resultDropdown.css("display", "block").html(data);
                }
            });
            $(".searchbar input.navigation-search").css({ 'border-bottom-left-radius' : '0px', 'border-bottom-right-radius' : '0px'});
        }
        else {
            resultDropdown.hide().html(''); 
            $(".searchbar input.navigation-search").css("border-radius", "0.25rem"); }
    });

    $(document).on("click", function(e) {
        if($(".navigation-search-results").css("display") == 'block' && e.target.classname != 'navigation-search-results') {
            $(".navigation-search-results").hide().html(''); 
            $(".searchbar input.navigation-search").css("border-radius", "0.25rem");
        }
    });
});

function createCookie(name,value,days) {
    if (days) {
        var date = new Date();
        date.setTime(date.getTime()+(days*24*60*60*1000));
        var expires = "; expires="+date.toGMTString();
    }
    else var expires = "";
    document.cookie = name+"="+value+expires+";";
}

function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}