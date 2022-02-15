<?php
    setlocale(LC_CTYPE, "bs_BA");

    $config = parse_ini_file(dirname(__DIR__) . "/layout.ini");

    define('DB_HOST', $config['servername']);
    define('DB_NAME', $config['database']);
    define('DB_USER', $config['username']);
    define('DB_PASS', $config['password']);

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";";
        
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options); } 
        
    catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode()); }

    $platforminfo = array ( 
        'name' => 'Recenzent',
        'supportmail' => 'support@recenzent.ba',
        'url' => 'recenzent.ba'
    );

    $tables = [

        'CREATE TABLE IF NOT EXISTS `korisnici` (
            `id` VARCHAR(24) NOT NULL PRIMARY KEY,
            `ime` VARCHAR(32) NOT NULL,
            `prezime` VARCHAR(64) NOT NULL,
            `email` VARCHAR(256) NOT NULL,
            `lozinka` VARCHAR(64) NOT NULL,
            `profilnaslika` VARCHAR(255) NOT NULL DEFAULT "images/defaultavatar.png");',

        'CREATE TABLE IF NOT EXISTS kategorije (
            `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `naziv` VARCHAR(48) NOT NULL UNIQUE,
            `znacajke` TEXT NULL,
            `brojObjekata` INT DEFAULT 0);',

        'CREATE TABLE IF NOT EXISTS `listing` (
            `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `vlasnik` VARCHAR(96) NOT NULL,
            `plan` INT NOT NULL,
            `naziv` VARCHAR(128) NOT NULL,
            `kategorija` VARCHAR(48) NOT NULL,
            `podkategorija` VARCHAR(48) NOT NULL,
            `kontaktTelefon` VARCHAR(16) NOT NULL,
            `adresa` VARCHAR(256) NOT NULL,
            `koordinate` TEXT DEFAULT NULL,
            `listingData` TEXT DEFAULT NULL,
            `galleryData` TEXT DEFAULT NULL,
            `brojRecenzija` INT DEFAULT 0,
            `prosjecnaOcjena` FLOAT DEFAULT 0);',

        'CREATE TABLE IF NOT EXISTS `gradovi` (
            `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `naziv` VARCHAR(36) NOT NULL UNIQUE,
            `brojObjekata` INT DEFAULT 0);'
    ];

    foreach($tables as $table) {
        $pdo->exec($table);
    }

?>