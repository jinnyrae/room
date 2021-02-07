<?php
$pdo = new PDO('mysql:host=localhost;dbname=room', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')); 


session_start();



define('RACINE_SITE', '/room-jinan/'); 



$contenu = '';


require_once 'functions.php'; 