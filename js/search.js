function checkViewport() {
    if(jQuery(window).width() < 576) {
        var offset = jQuery("#mobilenavigation > .mobilenav-header").outerHeight(true);
        jQuery("body").css("padding-top", offset);
        jQuery("button.filters").prop("disabled", false);
    }
    else {
        var offset = jQuery("#navigation").outerHeight(true);
        jQuery("body").css("padding-top", offset);
        jQuery("button.filters").prop("disabled", true);
    }
}

function removeFilters() { jQuery('form#filter input[type="checkbox"]').prop({ "checked" :  false, "disabled" : false }).trigger("change"); }

jQuery(document).ready(function() {
    
    checkViewport();

    $(window).resize(function() {
        var vh = window.innerHeight * 0.01;
        document.documentElement.style.setProperty('--vh', `${vh}px`);
        checkViewport();
    });

    $("body").on("click", ".filters-group-dropdown.sortiranje p", function() {
        var vrijednost = $(this).attr("data-value");
        $("input.search-sortiranje").val(vrijednost).trigger("change");
        alert($("input.search-sortiranje").val());
        alert($("#filter").serialize());
    })

    $("body").on("change", "#filter input", function() {
        $("#search .results-container > .container").html('<i class="fas fa-spinner fa-spin loader"></i>');

        if($("form#filter input:checkbox:checked").length)
        {
            if(!$("button#removeFilters").length)
            {
                button = '<button type="button" class="filled" onClick="removeFilters()" id="removeFilters">Očisti filtere</button>';
                $(button).appendTo("#search .header")
            }
        }
        else
        {
            $("button#removeFilters").remove();
        }

        if($(this).attr("name") == 'kategorije[]')
        {
            var val = $(this).val();
            var klasa = val.replace(/\s/g, '');
            $(".filters-group." + klasa).remove();
            if(this.checked)
            {
                $.ajax({
                    type: 'GET',
                    url: 'formvalidation/populatefeatures.php',
                    data: { 'kategorija' : val },
                    dataType: 'json',
                    success: function(data) {
                        append = '<div class="filters-group ' + klasa + '"><span class="filters-name"><p>' + val + ' - značajke</p></span><div class="filters-group-dropdown">';

                        $.each(data[0], function(index, value) {
                            append += '<label class="checkbox-custom"><p>' + value + '</p><input type="checkbox" name="znacajke[]" value="' + value + '"><span class="checkbox-custom-control"></span></label>';
                        })

                        append += '</div></div>';

                        $(append).insertAfter($("#filter .covidregulative"));
                    }
                })
            }
        }
        $.ajax({
            type: 'GET',
            url: 'formvalidation/livesearch.php',
            data: $("#filter").serialize(),
            dataType: 'json',
            success: function(data) {
                var listing = data.listing_data;
                lokacije = data.markeri_data;
                var append, i = 0, marker;

                $("#search .results-container").html("");

                for(const element of listing) {
                    var listingData = JSON.parse(element['listingData']);
                    var galleryData = JSON.parse(element['galleryData']);
                    var marker = JSON.parse(element['koordinate']);

                    if(element['prosjecnaOcjena'] == 0) { ocjena = '<p>Nema recenzija'; }
                    else { ocjena = '<span class="material-icons-outlined md-20 md-dark md-inactive">grade</span><p>' + element['prosjecnaOcjena'] + ' (' + element['brojRecenzija'] + ' recenzija)'; }

                    append = '<div class="listing"><div class="search-thumbnail">';
                    if(!galleryData['slike'].length) { 
                        append += '<img src="images/listing-placeholder-logo.png" />'; }
                    else {
                        append += '<img src=".' + galleryData['putanja'] + galleryData['slike'][0] + '" />'; }

                    append += '<div class="labels">' +
                              '<div class="category"><a href="search.php?pretraga=' + element['kategorija'] + '" class="search-result-category" title="Pretraga po kategoriji">' + element['kategorija'] + '</a></div>' +
                              '<div class="bookmark"><a href="#" title="Spremi listing"><i class="fa-regular fa-heart fa-fw"></i> Spremi</a></div></div></div>';
                            
                    append += '<div class="data">' +
                              '<div class="data-body"><a href="listing.php?id=' + element['id'] + '" class="search-result">' + element['naziv'] + '</a></div>' +
                              '<div class="data-body" title="Rejting">' + ocjena + '</p>&middot;<p>' + element['podkategorija'] + '</p></div>' +
                              '<div class="data-info"><li title="Adresa"><i class="las la-map-marker fa-fw"></i><p>' + element['adresa'] + '</p></span>' +
                              '<li title="Kontakt telefon"><i class="las la-phone fa-fw"></i><p>' + element['kontaktTelefon'] + '</p></span></div></div>';

                    if(marker.length)  {
                        append += '<div class="data-footer"><a class="listing-lokacija" data-panto="' + element['naziv'] + '" href="#searchmap">Pokaži na mapi</a>' + element['currentStatus'] + '</div>'; }

                    append += '</div>';

                    $("#search .results-container").append(append);
                }

                for(i = 0; i < markeri.length; i++)
                {
                    markeri[i].setMap(null);
                }

                for(i = 0; i < lokacije.length; i++) {
                    marker = new google.maps.Marker({
                            position: new google.maps.LatLng(lokacije[i][1], lokacije[i][2]),
                            map: map
                    });
    
                    markeri.push(marker);

                    panto.filter(function(){ return $(this).data('panto') === lokacije[i][0]; }).on('click', (function(marker) { return function(){
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
                
            }
        });
    });

    if($("input[type='checkbox'][name='kategorije[]'][value='" + $("input.navigation-search").val() + "']")) {
        $("input[type='checkbox'][name='kategorije[]'][value='" + $("input.navigation-search").val() + "']").prop("checked", true).trigger("change");
    }
});