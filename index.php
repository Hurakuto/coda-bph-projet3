<?php

session_start();

require_once 'vendor/autoload.php';

// Chargement des variables d'environnement
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$route = new Router();
$route->handleRequest($_GET);