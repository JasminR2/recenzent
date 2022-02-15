<section id="navigation">

    <div class="container">

        <a href="index.php" class="navbar-brend"><?php echo $platforminfo['name']; ?></a>

        <div class="searchbar">
            <i class="las la-search fa-fw search"></i>
            <form method="GET" action="search.php"><input class="navigation-search" type="search" name="pretraga" placeholder="Pretraga" autocomplete="off" value="<?php $_pretraga = isset($_REQUEST['pretraga']) ? $_REQUEST['pretraga'] : NULL; echo $_pretraga ?>">
            <div class="navigation-search-results"></div></form>
        </div>

        <div class="column">

            <a href="mailto:<?php echo $platforminfo['supportmail']; ?>" class="navbar-support"><?php echo $platforminfo['supportmail']; ?></a>

            <div class="dropdown" tabindex="0">
                <button type="button" class="dropbtn-filled">Račun<span class="material-icons-outlined md-20">expand_more</span></button>
                <div class="dropdown-menu">
                    <?php
                        if(!isset($_SESSION["user_loggedin"]) || $_SESSION["user_loggedin"] == false) {
                            echo '
                                <h6>Povežite se</h6>
                                <div class="group">
                                    <a href="register.php"><span class="material-icons-outlined mr-1 md-18">person_add_alt</span>Registracija</a>
                                    <a href="login.php"><span class="material-icons-outlined mr-1 md-18">login</span>Prijava</a>
                                </div>
                            ';
                        }
                        else {
                            echo '
                                <h6>Moj račun</h6>
                                <div class="group">
                                    <a href="profile.php"><span class="material-icons-outlined mr-1 md-18">account_circle</span>Profil</a>
                                    <a href="bookmarks.php"><span class="material-icons-outlined mr-1 md-18">bookmark_border</span>Spremljeno</a>
                                    <a href="settings.php"><span class="material-icons-outlined mr-1 md-18">settings</span>Postavke</a>
                                </div>
                            ';
                        }
                    ?>
                    <h6>Više</h6>
                    <div class="group">
                        <a href="addlisting.php"><span class="material-icons-outlined mr-1 md-18">add_box</span>Dodaj listing</a>
                        <a href="help.php"><span class="material-icons-outlined mr-1 md-18">support</span>Pomoć</a>
                        <a href="feedback.php"><span class="material-icons-outlined mr-1 md-18">question_answer</span>Povratne informacije</a>
                        <a href="bugreport.php"><span class="material-icons-outlined mr-1 md-18">bug_report</span>Prijavite problem</a>
                    </div>
                    <?php
                        if(isset($_SESSION["user_loggedin"]) && $_SESSION["user_loggedin"] == true) {
                            echo '
                                <div class="dropdown-divider"></div>
                                <a href="logout.php"><span class="material-icons-outlined mr-1 md-18">logout</span>Odjava</a>
                            ';
                        }
                    ?>
                </div>
            </div>

        </div>

    </div>

    <nav>

        <a href="index.php" class="navigation">Početna</a>
        <a href="events.php" class="navigation">Eventi</a>
        <a href="search.php" class="navigation">Traži</a>
        <a href="trending.php" class="navigation">U trendu</a>
        <a href="blog.php" class="navigation">Blog</a>

    </nav>

</section>