<section id="mobilenavigation">


    <div class="mobilenav-header">
        <div class="container">
            <a href="index.php" class="navbar-brend"><img src="images/logo.png"><?php echo $platforminfo['name']; ?></a>

            <button class="navopener" type="button"><span class="material-icons-outlined md-24">menu</span></button>

            <div class="searchbar">
                <i class="las la-search fa-fw search"></i>
                <form method="GET" action="search.php"><input class="navigation-search" type="search" name="pretraga" placeholder="Pretraga" autocomplete="off">
                <div class="navigation-search-results"></div></form>
            </div>
        </div>
    </div>

    <div class="container">
        <nav>

            <div class="group">

                <h6 class="title">Navigacija</h6>
                <a href="index.php"><span class="material-icons-outlined mr-1 md-18">home</span>Početna</a>
                <a href="events.php"><span class="material-icons-outlined mr-1 md-18">event</span>Eventi</a>
                <a href="search.php"><span class="material-icons-outlined mr-1 md-18">search</span>Traži</a>
                <a href="trending.php"><span class="material-icons-outlined mr-1 md-18">trending_up</span>U trendu</a>
                <a href="blog.php"><span class="material-icons-outlined mr-1 md-18">feed</span>Blog</a>

            </div>

            <?php
                if(!isset($_SESSION["user_loggedin"]) || $_SESSION["user_loggedin"] == false) {
                    echo '
                        <div class="group">

                            <h6 class="title">Povežite se</h6>
                            <a href="register.php"><span class="material-icons-outlined mr-1 md-18">person_add_alt</span>Registracija</a>
                            <a href="login.php"><span class="material-icons-outlined mr-1 md-18">login</span>Prijava</a>

                        </div>
                    ';
                }
                else {
                    echo '
                        <div class="group">

                            <h6 class="title">Moj račun</h6>
                            <a href="profile.php"><span class="material-icons-outlined mr-1 md-18">account_circle</span>Profil</a>
                            <a href="bookmarks.php"><span class="material-icons-outlined mr-1 md-18">bookmark_border</span>Spremljeno</a>
                            <a href="settings.php"><span class="material-icons-outlined mr-1 md-18">settings</span>Postavke</a>
                            <a href="logout.php"><span class="material-icons-outlined mr-1 md-18">logout</span>Odjava</a>
                        
                        </div>
                    ';
                }

            ?>

            <div class="group">

                <h6 class="title">Više</h6>
                <a href="addlisting.php"><span class="material-icons-outlined mr-1 md-18">add_box</span>Dodaj listing</a>
                <a href="help.php"><span class="material-icons-outlined mr-1 md-18">support</span>Pomoć</a>
                <a href="feedback.php"><span class="material-icons-outlined mr-1 md-18">question_answer</span>Povratne informacije</a>
                <a href="bugreport.php"><span class="material-icons-outlined mr-1 md-18">bug_report</span>Prijavite problem</a>

            </div>

        </nav>
    </div>

</section>