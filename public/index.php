<?php

require_once __DIR__ . '/../vendor/autoload.php';

use HackbartPR\Config\ConnectionCreator;
use HackbartPR\Repository\PDOUserRepository;
use HackbartPR\Repository\PDOVideoRepository;
use HackbartPR\Controller\Response404Controller;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;

session_start();
session_regenerate_id();

$path = $_SERVER['PATH_INFO'] ?? '/';
$method = $_SERVER['REQUEST_METHOD'];

$conn = ConnectionCreator::createConnection();

if ((!array_key_exists('logged', $_SESSION) || !$_SESSION['logged']) && $path !== '/login') {
    header('Location: /login');
    exit();
} 

$repository = null;
if ($path === '/login' || $path === '/logout') {
    $repository = new PDOUserRepository($conn);
} else {
    $repository = new PDOVideoRepository($conn);
}

$router = require_once __DIR__ . '/../routes/router.php';
$routerClass = $router["$method|$path"];

if (array_key_exists("$method|$path", $router)) {    
    $controller = new $routerClass($repository);       
} else {    
    $controller = new Response404Controller();
}

/* Criando uma requisição */
$psr17Factory = new Psr17Factory();
$creator = new ServerRequestCreator(
    $psr17Factory, // ServerRequestFactory
    $psr17Factory, // UriFactory
    $psr17Factory, // UploadedFileFactory
    $psr17Factory  // StreamFactory
);
$request = $creator->fromGlobals();

/** @var \Psr\Http\Server\RequestHandlerInterface $controller */
$response = $controller->handle($request);

/* Envia o status da requisição */
http_response_code($response->getStatusCode());

/* Recupera o header da response */
foreach ($response->getHeaders() as $name => $values) {        
    foreach ($values as $value) {
        header(sprintf('%s: %s', $name, $value), false);
    }
}

/* Imprimindo o corpo da resposta da requisição */
echo $response->getBody();
