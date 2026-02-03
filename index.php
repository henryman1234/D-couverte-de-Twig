<?php

use Twig\Environment;
use Twig\Extra\Markdown\MichelfMarkdown;
use Twig\Loader\FilesystemLoader;

require "vendor/autoload.php";


// Routing
$page = "home";

if (isset($_GET["p"])) {
    $page = $_GET["p"];
}

//recupère les derniers tutoriels
function tutorials  () {
    $pdo = new PDO("mysql:host=localhost;dbname=grafikart", "root", "root");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $tutorials = $pdo->query("SELECT * FROM tutoriels ORDER BY id DESC LIMIT 10");
    return $tutorials;
}


// Rendu du template
$loader = new FilesystemLoader(__DIR__."/templates");
$twig = new Environment($loader, [
    // "cache" => __DIR__."/tmp"
    "cache" => false
]); 

switch ($page) {
    case "home":
        echo $twig->render("home.twig");
        break;
    case "contact":
        echo $twig->render("contact.twig");
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        echo $twig->render("error.twig");
        break;
}




