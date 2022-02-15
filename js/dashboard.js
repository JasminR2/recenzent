jQuery(document).ready(function() {
    $("body").on("click", "button.addfeature", function() {
        var faqparent = $(".faq-container");
        var countfaq = $('.faq-container > .faq').length;
        if(countfaq >= 5) {
            alert("Možete dodati najviše 5 pitanja.");
            $(".faq-container > .faq:last").remove();
        }
        
        $('<div class="inputwrapper">' +
          '<label for="category-feature">Značajke kategorije:' +
          '<input type="text" name="znacajkekategorije[]" placeholder="unesite značajku">' +
          '</div>').insertBefore($(this));
    });

});