<?php

return [
    'GET|/' => \HackbartPR\Controller\ShowVideoController::class,
    'GET|/novo' => \HackbartPR\Controller\SendVideoController::class,
    'POST|/novo' => \HackbartPR\Controller\NewVideoController::class,
    'GET|/editar' => \HackbartPR\Controller\SendVideoController::class,
    'POST|/editar' => \HackbartPR\Controller\UpdateVideoController::class,
    'GET|/remover' => \HackbartPR\Controller\RemoveVideoController::class,
    'GET|/login' => \HackbartPR\Controller\LoginController::class,
    'POST|/login' => \HackbartPR\Controller\VerifyLoginController::class,
    'GET|/logout' => \HackbartPR\Controller\LogoutController::class,
    'GET|/json-videos' => \HackbartPR\Controller\JsonVideoListController::class,
];