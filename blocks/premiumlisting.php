<?php

    include(dirname(__DIR__) . "../functions.php");

    $katlist = listAllCategories();
    
?>


<form method="POST" id="basic">
    <script>
            jQuery(document).ready(function(), {
                $("#kategorija").selectMenu();
            });
        </script>
    <input type="hidden" name="subscription_plan" value="basic">

    <div class="header">
    
        <h3>Kreiranje listinga</h3>

        <button type="button" class="filled go_back"><i class="fa-solid fa-arrow-left fa-fw"></i> natrag</button>

    </div>

    <div class="group">

        <h5>Generalno</h5>
        <p class="info" title="Pomoć">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam mattis rhoncus neque ac hendrerit. Fusce in lorem consequat, tristique mi.</p>

        <div class="inputwrapper">
            <label for="kategorija">Kategorija</label>
            <select name="kategorija" id="kategorija">
                <option value="" disabled hidden selected>odaberite kategoriju..</option>
                <?php

                    foreach($katlist as $kat) {
                        echo '<option value="' . $kat . '">' . $kat . '</option>';
                    }

                ?>
            </select>
        </div>

        <div class="inputwrapper">
            <label for="nazivlistinga">Naziv</label>
            <input type="text" placeholder="unesite naziv biznisa.." name="nazivlistinga" id="nazivlistinga" autocomplete="off">
        </div>

        <div class="inputwrapper">
            <label for="kontakttelefon">Kontakt telefon</label>
            <input type="text" placeholder="unesite kontakt telefon.." name="kontakttelefon" id="kontakttelefon" oninput="this.value=this.value.replace(/[^0-9]/g,'');" autocomplete="off">
        </div>

    </div>

    <div class="group">

        <h5>Lokacija</h5>
        <p class="info" title="Pomoć">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam mattis rhoncus neque ac hendrerit. Fusce in lorem consequat, tristique mi.</p>

        <div class="inputwrapper">
            <label for="grad">Grad</label>
            <input type="text" placeholder="unesite grad" name="grad" id="grad" autocomplete="off">
        </div>

        <div class="inputwrapper">
            <label for="ulica">Ulica i broj</label>
            <input type="text" placeholder="unesite naziv ulice" name="ulica" id="ulica" autocomplete="off">
        </div>

        <div class="inputwrapper">
            <label for="postanskibroj">Poštanski broj</label>
            <input type="text" placeholder="unesite poštanski broj grada" name="postanskibroj" id="postanskibroj" oninput="this.value=this.value.replace(/[^0-9]/g,'');" autocomplete="off">
        </div>

    </div>

    <div class="group">

        <h5>Covid-19 regulative</h5>
        <p class="info" title="Pomoć">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam mattis rhoncus neque ac hendrerit. Fusce in lorem consequat, tristique mi.</p>

        <div class="featureset">

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

    <div class="group" id="workinghours">

        <h5>Radno vrijeme</h5>
        <p class="info" title="Pomoć">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam mattis rhoncus neque ac hendrerit. Fusce in lorem consequat, tristique mi.</p>

        <div class="wrapper" id="ponedjeljak">

            <p>Ponedjeljak</p>

            <input type="time" name="ponedjeljakpocetak">

            <input type="time" name="ponedjeljakkraj">

        </div>

        <div class="wrapper" id="utorak">

            <p>Utorak</p>

            <input type="time" name="utorakpocetak">

            <input type="time" name="utorakkraj">

        </div>

        <div class="wrapper" id="srijeda">

            <p>Srijeda</p>

            <input type="time" name="srijedapocetak">

            <input type="time" name="srijedakraj">

        </div>

        <div class="wrapper" id="cetvrtak">

            <p>Četvrtak</p>

            <input type="time" name="cetvrtakpocetak">

            <input type="time" name="cetvrtakkraj">

        </div>

        <div class="wrapper" id="petak">

            <p>Petak</p>

            <input type="time" name="petakpocetak">

            <input type="time" name="petakkraj">

        </div>
        
        <div class="wrapper" id="subota">

            <p>Subota</p>

            <input type="time" name="subotapocetak">

            <input type="time" name="subotakraj">

        </div>

        <div class="wrapper" id="nedjelja">

            <p>Nedjelja</p>

            <input type="time" name="nedjeljapocetak">

            <input type="time" name="nedjeljakraj">

        </div>

    </div>

    <div class="group agreement">

        <label class="checkbox-custom"><p>Prihvatam <a href="#">Pravila privatnosti</a>.</p>
            <input type="checkbox" name="pravilaprivatnosti">
            <span class="checkbox-custom-control" id="pravilaprivatnosti"></span>
        </label>


        <label class="checkbox-custom"><p>Prihvatam <a href="#">Uslove korištenja</a>.</p>
            <input type="checkbox" name="uslovikoristenja">
            <span class="checkbox-custom-control" id="uslovikoristenja"></span>
        </label>

    </div>

    <button type="submit" class="filled submit-listing">Pošalji <i class="fa-solid fa-arrow-right fa-fw"></i></button>
</form>


<form method="POST" id="standard" enctype="multipart/form-data">
    <input type="hidden" name="subscription_plan" value="standard">

    <div class="header">
        
        <h3>Kreiranje listinga</h3>

        <button type="button" class="filled go_back"><i class="fa-solid fa-arrow-left fa-fw"></i> natrag</button>

    </div>

    <div class="group">

        <h5>Generalno</h5>
        <p class="info" title="Pomoć">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam mattis rhoncus neque ac hendrerit. Fusce in lorem consequat, tristique mi.</p>

        <div class="inputwrapper">
            <label for="kategorija">Kategorija</label>
            <select name="kategorija" id="kategorija">
                <option value="" disabled hidden selected>odaberite kategoriju..</option>
                <?php

                    foreach($katlist as $kat) {
                        echo '<option value="' . $kat . '">' . $kat . '</option>';
                    }

                ?>
            </select>
        </div>

        <div class="inputwrapper">
            <label for="nazivlistinga">Naziv</label>
            <input type="text" placeholder="unesite naziv biznisa.." name="nazivlistinga" id="nazivlistinga" autocomplete="off">
        </div>

        <div class="inputwrapper">
            <label for="kontakttelefon">Kontakt telefon</label>
            <input type="text" placeholder="unesite kontakt telefon.." name="kontakttelefon" id="kontakttelefon" oninput="this.value=this.value.replace(/[^0-9]/g,'');" autocomplete="off">
        </div>

    </div>

    <div class="group">

        <h5>Lokacija</h5>
        <p class="info" title="Pomoć">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam mattis rhoncus neque ac hendrerit. Fusce in lorem consequat, tristique mi.</p>

        <div class="inputwrapper">
            <label for="grad">Grad</label>
            <input type="text" placeholder="unesite grad" name="grad" id="grad" autocomplete="off">
        </div>

        <div class="inputwrapper">
            <label for="ulica">Ulica i broj</label>
            <input type="text" placeholder="unesite naziv ulice" name="ulica" id="ulica" autocomplete="off">
        </div>

        <div class="inputwrapper">
            <label for="postanskibroj">Poštanski broj</label>
            <input type="text" placeholder="unesite poštanski broj grada" name="postanskibroj" id="postanskibroj" oninput="this.value=this.value.replace(/[^0-9]/g,'');" autocomplete="off">
        </div>

    </div>

    <div class="group">

        <h5>Lokacija na mapi</h5>
        <p class="info" title="Pomoć">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam mattis rhoncus neque ac hendrerit. Fusce in lorem consequat, tristique mi.</p>

        <div id="map" style="height: 35vh !important; width: 100%;"></div>
    
    </div>

    <div class="group">

        <h5>Opšte značajke</h5>
        <p class="info" title="Pomoć">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam mattis rhoncus neque ac hendrerit. Fusce in lorem consequat, tristique mi.</p>

        <div class="featureset">

            <label class="checkbox-custom"><p>Besplatan WiFi</p>
                <input type="checkbox" name="opsteznacajke[]" value="Besplatan WiFi">
                <span class="checkbox-custom-control"></span>
            </label>

            <label class="checkbox-custom"><p>Besplatan parking</p>
                <input type="checkbox" name="opsteznacajke[]" value="Besplatan parking">
                <span class="checkbox-custom-control"></span>
            </label>

            <label class="checkbox-custom"><p>Kartično plaćanje</p>
                <input type="checkbox" name="opsteznacajke[]" value="Kartično plaćanje">
                <span class="checkbox-custom-control"></span>
            </label>

            <label class="checkbox-custom"><p>Pušenje zabranjeno</p>
                <input type="checkbox" name="opsteznacajke[]" value="Pušenje zabranjeno">
                <span class="checkbox-custom-control"></span>
            </label>

            <label class="checkbox-custom"><p>Pet friendly</p>
                <input type="checkbox" name="opsteznacajke[]" value="Pet friendly">
                <span class="checkbox-custom-control"></span>
            </label>

            <label class="checkbox-custom"><p>Klimatizirano</p>
                <input type="checkbox" name="opsteznacajke[]" value="Klimatizirano">
                <span class="checkbox-custom-control"></span>
            </label>

        </div>

    </div>

    <div class="group">

        <h5>Covid-19 regulative</h5>
        <p class="info" title="Pomoć">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam mattis rhoncus neque ac hendrerit. Fusce in lorem consequat, tristique mi.</p>

        <div class="featureset">

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

    <div class="group" id="workinghours">

        <h5>Radno vrijeme</h5>
        <p class="info" title="Pomoć">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam mattis rhoncus neque ac hendrerit. Fusce in lorem consequat, tristique mi.</p>

        <div class="wrapper" id="ponedjeljak">

            <p>Ponedjeljak</p>

            <input type="time" name="ponedjeljakpocetak">

            <input type="time" name="ponedjeljakkraj">

        </div>

        <div class="wrapper" id="utorak">

            <p>Utorak</p>

            <input type="time" name="utorakpocetak">

            <input type="time" name="utorakkraj">

        </div>

        <div class="wrapper" id="srijeda">

            <p>Srijeda</p>

            <input type="time" name="srijedapocetak">

            <input type="time" name="srijedakraj">

        </div>

        <div class="wrapper" id="cetvrtak">

            <p>Četvrtak</p>

            <input type="time" name="cetvrtakpocetak">

            <input type="time" name="cetvrtakkraj">

        </div>

        <div class="wrapper" id="petak">

            <p>Petak</p>

            <input type="time" name="petakpocetak">

            <input type="time" name="petakkraj">

        </div>
        
        <div class="wrapper" id="subota">

            <p>Subota</p>

            <input type="time" name="subotapocetak">

            <input type="time" name="subotakraj">

        </div>

        <div class="wrapper" id="nedjelja">

            <p>Nedjelja</p>

            <input type="time" name="nedjeljapocetak">

            <input type="time" name="nedjeljakraj">

        </div>

    </div>

    <div class="group">

        <h5>Socijalne mreže</h5>
        <p class="info" title="Pomoć">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam mattis rhoncus neque ac hendrerit. Fusce in lorem consequat, tristique mi.</p>

        <div class="inputwrapper">
            <label for="facebookurl">Facebook</label>
            <input type="text" placeholder="Facebook stranica" name="socijalnemreze[Facebook][]" autocomplete="off">
        </div>

        <div class="inputwrapper">
            <label for="instagramurl">Instagram</label>
            <input type="text" placeholder="Instagram stranica" name="socijalnemreze[Instagram][]" autocomplete="off">
        </div>

        <div class="inputwrapper">
            <label for="twitterurl">Twitter</label>
            <input type="text" placeholder="Twitter stranica" name="socijalnemreze[Twitter][]" autocomplete="off">
        </div>

        <div class="inputwrapper">
            <label for="websiteurl">Web stranica</label>
            <input type="text" placeholder="Web stranica" name="socijalnemreze[Website][]" autocomplete="off">
        </div>

    </div>

    <div class="group">

        <h5>Prenesite slike</h5>
        <p class="info" title="Pomoć">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam mattis rhoncus neque ac hendrerit. Fusce in lorem consequat, tristique mi.</p>

        <label class="file-upload">
            <input type="file" name="galleryphotos[]" id="galleryphotos" multiple accept=".jpg, .jpeg, .png">
            <i class="fa-solid fa-cloud-arrow-up"></i>
            <h4>Prenesite slike</h4>
            <input type="hidden" id="passingImages" name="passingImages" value="" />
        </label>

        <div class="gallery-preview"></div>

    </div>

    <div class="group agreement">

        <label class="checkbox-custom"><p>Prihvatam <a href="#">Pravila privatnosti</a>.</p>
            <input type="checkbox" name="pravilaprivatnosti">
            <span class="checkbox-custom-control" id="pravilaprivatnosti"></span>
        </label>


        <label class="checkbox-custom"><p>Prihvatam <a href="#">Uslove korištenja</a>.</p>
            <input type="checkbox" name="uslovikoristenja">
            <span class="checkbox-custom-control" id="uslovikoristenja"></span>
        </label>

    </div>

    <button type="submit" class="filled submit-listing">Pošalji <i class="fa-solid fa-arrow-right fa-fw"></i></button>
</form>



<form method="POST" id="premium" enctype="multipart/form-data">
    <input type="hidden" name="subscription_plan" value="premium">

    <div class="header">
        
        <h3>Kreiranje listinga</h3>

        <button type="button" class="filled go_back"><i class="fa-solid fa-arrow-left fa-fw"></i> natrag</button>

    </div>

    <div class="group">

        <h5>Generalno</h5>
        <p class="info" title="Pomoć">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam mattis rhoncus neque ac hendrerit. Fusce in lorem consequat, tristique mi.</p>

        <div class="inputwrapper">
            <label for="kategorija">Kategorija</label>
            <select name="kategorija" id="kategorija">
                <option value="" disabled hidden selected>odaberite kategoriju..</option>
                <?php

                    foreach($katlist as $kat) {
                        echo '<option value="' . $kat . '">' . $kat . '</option>';
                    }

                ?>
            </select>
        </div>

        <div class="inputwrapper">
            <label for="nazivlistinga">Naziv</label>
            <input type="text" placeholder="unesite naziv biznisa.." name="nazivlistinga" id="nazivlistinga" autocomplete="off">
        </div>

        <div class="inputwrapper">
            <label for="kontakttelefon">Kontakt telefon</label>
            <input type="text" placeholder="unesite kontakt telefon.." name="kontakttelefon" id="kontakttelefon" oninput="this.value=this.value.replace(/[^0-9]/g,'');" autocomplete="off">
        </div>

    </div>

    <div class="group">

        <h5>Lokacija</h5>
        <p class="info" title="Pomoć">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam mattis rhoncus neque ac hendrerit. Fusce in lorem consequat, tristique mi.</p>

        <div class="inputwrapper">
            <label for="grad">Grad</label>
            <input type="text" placeholder="unesite grad" name="grad" id="grad" autocomplete="off">
        </div>

        <div class="inputwrapper">
            <label for="ulica">Ulica i broj</label>
            <input type="text" placeholder="unesite naziv ulice" name="ulica" id="ulica" autocomplete="off">
        </div>

        <div class="inputwrapper">
            <label for="postanskibroj">Poštanski broj</label>
            <input type="text" placeholder="unesite poštanski broj grada" name="postanskibroj" id="postanskibroj" oninput="this.value=this.value.replace(/[^0-9]/g,'');" autocomplete="off">
        </div>

    </div>

    <div class="group">

        <h5>Lokacija na mapi</h5>
        <p class="info" title="Pomoć">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam mattis rhoncus neque ac hendrerit. Fusce in lorem consequat, tristique mi.</p>

        <div id="map" style="height: 35vh !important; width: 100%;"></div>
    
    </div>

    <div class="group">

        <h5>Opšte značajke</h5>
        <p class="info" title="Pomoć">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam mattis rhoncus neque ac hendrerit. Fusce in lorem consequat, tristique mi.</p>

        <div class="featureset">

            <label class="checkbox-custom"><p>Besplatan WiFi</p>
                <input type="checkbox" name="opsteznacajke[]" value="Besplatan WiFi">
                <span class="checkbox-custom-control"></span>
            </label>

            <label class="checkbox-custom"><p>Besplatan parking</p>
                <input type="checkbox" name="opsteznacajke[]" value="Besplatan parking">
                <span class="checkbox-custom-control"></span>
            </label>

            <label class="checkbox-custom"><p>Kartično plaćanje</p>
                <input type="checkbox" name="opsteznacajke[]" value="Kartično plaćanje">
                <span class="checkbox-custom-control"></span>
            </label>

            <label class="checkbox-custom"><p>Pušenje zabranjeno</p>
                <input type="checkbox" name="opsteznacajke[]" value="Pušenje zabranjeno">
                <span class="checkbox-custom-control"></span>
            </label>

            <label class="checkbox-custom"><p>Pet friendly</p>
                <input type="checkbox" name="opsteznacajke[]" value="Pet friendly">
                <span class="checkbox-custom-control"></span>
            </label>

            <label class="checkbox-custom"><p>Klimatizirano</p>
                <input type="checkbox" name="opsteznacajke[]" value="Klimatizirano">
                <span class="checkbox-custom-control"></span>
            </label>

        </div>

    </div>

    <div class="group">

        <h5>Covid-19 regulative</h5>
        <p class="info" title="Pomoć">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam mattis rhoncus neque ac hendrerit. Fusce in lorem consequat, tristique mi.</p>

        <div class="featureset">

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

    <div class="group" id="workinghours">

        <h5>Radno vrijeme</h5>
        <p class="info" title="Pomoć">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam mattis rhoncus neque ac hendrerit. Fusce in lorem consequat, tristique mi.</p>

        <div class="wrapper" id="ponedjeljak">

            <p>Ponedjeljak</p>

            <input type="time" name="ponedjeljakpocetak">

            <input type="time" name="ponedjeljakkraj">

        </div>

        <div class="wrapper" id="utorak">

            <p>Utorak</p>

            <input type="time" name="utorakpocetak">

            <input type="time" name="utorakkraj">

        </div>

        <div class="wrapper" id="srijeda">

            <p>Srijeda</p>

            <input type="time" name="srijedapocetak">

            <input type="time" name="srijedakraj">

        </div>

        <div class="wrapper" id="cetvrtak">

            <p>Četvrtak</p>

            <input type="time" name="cetvrtakpocetak">

            <input type="time" name="cetvrtakkraj">

        </div>

        <div class="wrapper" id="petak">

            <p>Petak</p>

            <input type="time" name="petakpocetak">

            <input type="time" name="petakkraj">

        </div>
        
        <div class="wrapper" id="subota">

            <p>Subota</p>

            <input type="time" name="subotapocetak">

            <input type="time" name="subotakraj">

        </div>

        <div class="wrapper" id="nedjelja">

            <p>Nedjelja</p>

            <input type="time" name="nedjeljapocetak">

            <input type="time" name="nedjeljakraj">

        </div>

    </div>

    <div class="group">

        <h5>Ključne riječi ili tagovi</h5>
        <p class="info" title="Pomoć">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam mattis rhoncus neque ac hendrerit. Fusce in lorem consequat, tristique mi.</p>

        <input type="text" class="customTagify" name="kljucnerijeci" placeholder="unesite tagove..." style="width: 100% !important;">

    </div>

    <div class="group">

        <h5>Često postavljena pitanja</h5>
        <p class="info" title="Pomoć">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam mattis rhoncus neque ac hendrerit. Fusce in lorem consequat, tristique mi.</p>

        <div class="faq-container">

            <div class="faq" id="faq0">
                <input type="text" name="question[]" class="faq-question" placeholder="Pitanje" autocomplete="off">
                <textarea name="answer[]" class="faq-answer" placeholder="Odgovor"></textarea>
            </div>

            <button class="addfaq filled" type="button">Dodaj</button>
        </div>

    </div>

    <div class="group">

        <h5>Socijalne mreže</h5>
        <p class="info" title="Pomoć">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam mattis rhoncus neque ac hendrerit. Fusce in lorem consequat, tristique mi.</p>

        <div class="inputwrapper">
            <label for="facebookurl">Facebook</label>
            <input type="text" placeholder="Facebook stranica" name="socijalnemreze[Facebook]" autocomplete="off">
        </div>

        <div class="inputwrapper">
            <label for="instagramurl">Instagram</label>
            <input type="text" placeholder="Instagram stranica" name="socijalnemreze[Instagram]" autocomplete="off">
        </div>

        <div class="inputwrapper">
            <label for="twitterurl">Twitter</label>
            <input type="text" placeholder="Twitter stranica" name="socijalnemreze[Twitter]" autocomplete="off">
        </div>

        <div class="inputwrapper">
            <label for="websiteurl">Web stranica</label>
            <input type="text" placeholder="Web stranica" name="socijalnemreze[Website]" autocomplete="off">
        </div>

    </div>

    <div class="group">

        <h5>Prenesite slike</h5>
        <p class="info" title="Pomoć">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam mattis rhoncus neque ac hendrerit. Fusce in lorem consequat, tristique mi.</p>

        <label class="file-upload">
            <input type="file" name="galleryphotos[]" id="galleryphotos" multiple accept=".jpg, .jpeg, .png">
            <i class="fa-solid fa-cloud-arrow-up"></i>
            <h4>Prenesite slike</h4>
            <input type="hidden" id="passingImages" name="passingImages" value="" />
        </label>

        <div class="gallery-preview"></div>

    </div>

    <div class="group agreement">

        <label class="checkbox-custom"><p>Prihvatam <a href="#">Pravila privatnosti</a>.</p>
            <input type="checkbox" name="pravilaprivatnosti">
            <span class="checkbox-custom-control" id="pravilaprivatnosti"></span>
        </label>


        <label class="checkbox-custom"><p>Prihvatam <a href="#">Uslove korištenja</a>.</p>
            <input type="checkbox" name="uslovikoristenja">
            <span class="checkbox-custom-control" id="uslovikoristenja"></span>
        </label>

    </div>

    <button type="submit" class="filled submit-listing">Pošalji <i class="fa-solid fa-arrow-right fa-fw"></i></button>
</form>