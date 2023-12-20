<?php

// ici on va configurer nos accès à la BDD
// renommer ce fichier en init.php après avoir renseigné vos identifiants de connexion et le nom de votre BDD

const CONFIG = [
    'db' => [
        'HOST' => 'localhost',
        'DBNAME' => 'e-commerce',
        'PORT' => '3306',
        'USER' => 'root', // en général root par défaut
        'PWD' => '', // en général une chaine vide ou root
    ],
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
    ]
];

// pour lancer la session
session_start();



define('BASE', '/PHP/wanted/');

// paramètres
// DSN Data Source Name : type de BDD + url d'accès à la BDD + nom de la BDD + port + encodage éventuel
// identifiant user
// mdp user
// new PDO('mysql:host=localhost;dbname=wanted;port=3306', 'root', '');
