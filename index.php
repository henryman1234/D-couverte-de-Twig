<?php

use Michelf\MarkdownExtra;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Extra\Markdown\MichelfMarkdown;
use Twig\Extra\String\StringExtension;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\TwigTest;

require "vendor/autoload.php";
require "Monextension.php";


// Routing
$page = "home";

if (isset($_GET["p"])) {
    $page = $_GET["p"];
}

//recupère les derniers tutoriels
function tutorials  () {
    $pdo = new PDO("mysql:host=localhost;dbname=world;charset=utf8mb4", "root", "Murielle12345", );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $tutorials = $pdo->query("SELECT * FROM test ORDER BY id DESC LIMIT 10");
    return $tutorials;
}


// Rendu du template
$loader = new FilesystemLoader(__DIR__."/templates");
$twig = new Environment($loader, [
    // "cache" => __DIR__."/tmp"
    "cache" => false,
    "debug" => true
]); 

// $twig->addFunction(new TwigFunction("markdown", function($value){
//     return MarkdownExtra::defaultTransform($value);
// }, ["is_safe" => ["html"]]) );

// $twig->addFilter(new TwigFilter("markdown", function($value) {
//     return MarkdownExtra::defaultTransform($value);
// } , ["is_safe" => ["html"]]));

$twig->addExtension(new Monextension());
$twig->addExtension(new StringExtension());
$twig->addGlobal("current_page", $page);
$twig->addExtension(new DebugExtension());

switch ($page) {
    case "home":
        echo $twig->render("home.twig", ["tutorials" => tutorials()]);
        break;
    case "contact":
        echo $twig->render("contact.twig", ["name" => "Henry Euloge", "email" => "henrynomo68@gmail.com"]);
        break;
    default:
        header("HTTP/1.0 404 Not Found");
        echo $twig->render("error.twig");
        break;
}




