jQuery(document).ready(function() {

    window.galleryArray = [];

    $("body").on("click", "#newlisting > form button.go_back", function() {
        $("#packages").find("button").prop("disabled", false).html("Odaberi");
        $("#newlisting").fadeOut(function() {
            $("#newlisting > form").remove();
            $("#packages").css("display", "flex").hide().fadeIn("slow");
        });
    });

    $("#packages button").on("click", function() {
        var plan = $(this).attr("data-plan");
        $(this).html("<i class='fas fa-spinner fa-spin'></i>");
        $("#packages").find("button").prop("disabled", true);

        switch(plan) {
            case 'basic': {
                $("#newlisting").load("blocks/premiumlisting.php #basic", function() {
                    $("#packages").fadeOut(function() {
                        $("body").scrollTop(0);
                        $("#newlisting").css("display", "flex").hide().fadeIn("slow");
                        createCookie("userPlan", "basic", "1");
                    });
                });
                break;
            }
            case 'standard': {
                $("#newlisting").load("blocks/premiumlisting.php #standard", function() {
                    $("#packages").fadeOut(function() {
                        $("body").scrollTop(0);
                        $("#newlisting").css("display", "flex").hide().fadeIn("slow");
                        $.getScript("https://maps.googleapis.com/maps/api/js?key=AIzaSyCgSJ_TFGri9HLolC_XM2lThsal3sjPAOs&callback=mapaddListing");
                        createCookie("userPlan", "standard", "1");
                    });
                });
                break;
            }
            case 'premium': {
                $("#newlisting").load("blocks/premiumlisting.php #premium", function() {
                    $("#packages").fadeOut(function() {
                        var inputelem = document.querySelector("input[name=kljucnerijeci]");
        
                        new Tagify(inputelem, {
                            delimiters: ",",
                            pattern: /[a-zšđčćž]/,
                            maxTags: 15
                        });
                        $("body").scrollTop(0);
                        $("#newlisting").css("display", "flex").hide().fadeIn("slow");
                        $.getScript("https://maps.googleapis.com/maps/api/js?key=AIzaSyCgSJ_TFGri9HLolC_XM2lThsal3sjPAOs&callback=mapaddListing");
                        createCookie("userPlan", "premium", "1");
                    });
                });
                break;
            }
        }
    });

    $("body").on('change', "#kategorija", function() {
        var val = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'formvalidation/populatefeatures.php',
            data: { 'kategorija': val },
            dataType: 'json',
            success: function(data) {

                append = '<div class="group category"><h5>' + (val) + ' - značajke</h5><p class="info" title="Pomoć">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam mattis rhoncus neque ac hendrerit. Fusce in lorem consequat, tristique mi.</p><div class="featureset">';
                
                $.each(data[0], function(index, value) {
                    append += '<label class="checkbox-custom"><p>' + value + '</p><input type="checkbox" name="znacajkekategorije[]" value="' + value + '"><span class="checkbox-custom-control"></span></label>';
                });

                append += '</div></div>';

                $(".group.category").remove();
                $(append).insertBefore("#workinghours");
            },
            error: function() {
                alert('error');
            }
        });
    });

    $("body").on("click", "#newlisting button.addfaq", function() {
        var countfaq = $('.faq-container > .faq').length;
        if(countfaq >= 5) {
            alert("Možete dodati najviše 5 pitanja.");
            $(".faq-container > .faq:last").remove();
        }
        
        $('<div class="faq" id="faq' + countfaq + '" style="margin-top: 0.375rem;">' +
          '<input type="text" name="question[]" class="faq-question" placeholder="Pitanje">' +
          '<textarea name="answer[]" class="faq-answer" placeholder="Odgovor"></textarea>' +
          '</div>').insertBefore($(this));
    });

    $("body").on("change", "#newlisting #galleryphotos", function(e) { 
        var countimages = $(this)[0].files.length;
        var imagesparent = $(".gallery-preview");
        imagesparent.empty();
    
        if(getCookie("userPlan") == "standard") {
            if(countimages > 5) {
                alert("Najviše možete odabrati 5 slika.");
                $("#galleryphotos").val(null);
                e.preventDefault();
                return;
            }
        }

        else if(getCookie("userPlan") == "premium") {
            if(countimages > 10) {
                alert("Najviše možete odabrati 10 slika.");
                $("#galleryphotos").val(null);
                e.preventDefault();
                return;
            }
        }
    
        for(let i = 0; i < countimages; i++) {
            window.galleryArray.push($(this)[0].files[i].name);
            let reader = new FileReader();
            reader.onload = function(e) {
                $(imagesparent).append('<div class="photo-wrapper">' + '<img src="' + e.target.result + '">' + '<button type="button" class="photo-preview" value="' + i + '">Briši</button></div>');
            }
            imagesparent.show();
            reader.readAsDataURL($(this)[0].files[i]);
        }

        document.getElementById('passingImages').value = JSON.stringify(window.galleryArray);
    });

    $("body").on("click", "#newlisting button.photo-preview", function() {
        var imageid = $(this).val();
        $(this).parent().remove();
    
        var input = document.getElementById('galleryphotos');
        var files = input.files;
        if (files.length) {
            if(typeof files[imageid] !== "undefined") {
                var index = window.galleryArray.indexOf(files[imageid].name);
                window.galleryArray.splice(index, 1);
            }
        }
        
        document.getElementById('passingImages').value = JSON.stringify(window.galleryArray);
    });

    $("body").on("submit", "#newlisting form", function(e) {
        e.preventDefault();
        var data = $(this)[0];
        var formData = new FormData(data);
        $.ajax({
            type: 'POST',
            url: './formvalidation/createlisting.php',
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            beforeSend: function() {
                $("button.submit-listing").html("<i class='fas fa-spinner fa-spin'></i>").prop("disabled", true);
            },
            async: false,
            success: function(data) {
                setTimeout(function() { 
                    if(!data.success)
                    {
                        var foreach = 0;
                        $("button.submit-listing").html("Pošalji <i class='fa-solid fa-arrow-right fa-fw'></i>").prop("disabled", false);
                        $.each(data, function(index, value) {
                            
                            $("#newlisting form #" + value + "").css("border-color", "red").parent().addClass("incorrect");
                            alert(value);
                            foreach++;
                            if(foreach == data.length) { 
                                if($(window).width() < 576) { $('html, body').animate({ scrollTop: $(".incorrect:visible:first").offset().top - $("#mobilenavigation > .mobilenav-header").outerHeight(true) - 5 }, 1000); }
                                else { $('html, body').animate({ scrollTop: $(".incorrect:visible:first").offset().top - $("#navigation").outerHeight(true) - 5 }, 1500); }
                            }
                        });
                    }
                    else
                    {
                        setTimeout(function() {
                            $("button.submit-listing").html("uspiješno, redirekcija &emsp; <i class='fas fa-spinner fa-spin'></i>");
                        }, 1500);
                    }
                }, 2000);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert(textStatus + ' ' + errorThrown);
              }
        });
    });

    $("body").on("click", "#newlisting .incorrect input, select, span.checkbox-custom-control", function() {
        $(this).css("border-color", "");
        $(this).closest(".incorrect").removeClass("incorrect");
    });

    $("body").on("click", "#newlisting #workinghours input", function() {
        $(this).parent().css("border-color", "");
    });
});

var marker;

function mapaddListing() {
    
    const myLatlng = {
      lat: 43.856,
      lng: 18.413
    };

    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 10,
      center: myLatlng,
    });

    google.maps.event.addListener(map, 'click', function(e) {        
        if(marker) {
            marker.setPosition(e.latLng);
        }
        else {
            marker = new google.maps.Marker({
                position: e.latLng,
                draggable: true,
                map: map
            });
        }
        var lat = marker.getPosition().lat();
        var lng = marker.getPosition().lng();
        createCookie("markerLat", lat, "1");
        createCookie("markerLng", lng, "1");
    });

}
