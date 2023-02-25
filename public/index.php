<?php

require_once __DIR__ . '/../vendor/autoload.php';

use HackbartPR\Utils\Auth;
use HackbartPR\Utils\Image;
use HackbartPR\Utils\Message;
use HackbartPR\Config\ConnectionCreator;
use HackbartPR\Controller\LoginController;
use HackbartPR\Controller\LogoutController;
use HackbartPR\Repository\PDOUserRepository;
use HackbartPR\Repository\PDOVideoRepository;
use HackbartPR\Controller\NewVideoController;
use HackbartPR\Controller\SendVideoController;
use HackbartPR\Controller\ShowVideoController;
use HackbartPR\Controller\Response404Controller;
use HackbartPR\Controller\RemoveVideoController;
use HackbartPR\Controller\UpdateVideoController;
use HackbartPR\Controller\VerifyLoginController;

session_start();
session_regenerate_id();

$path = $_SERVER['PATH_INFO'] ?? '/';
$method = $_SERVER['REQUEST_METHOD'];

$auth = new Auth();
$image = new Image();
$message = new Message();
$conn = ConnectionCreator::createConnection();

if (!$auth->isLogged() && $path !== '/login') {
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
    if ($path === '/login' && $method === 'GET') {
        $controller = new $routerClass($message, $auth);
    } else if ($path === '/logout'){
        $controller = new $routerClass($auth);
    } else if (($path === '/novo' || $path === '/editar')&& $method === 'POST') {
        $controller = new $routerClass($repository, $message, $image);   
    } else {
        $controller = new $routerClass($repository, $message, $auth, $image);
    }    
} else {    
    $controller = new Response404Controller();
}

$controller->processRequest();