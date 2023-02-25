<?php

namespace HackbartPR\Controller;

use HackbartPR\Utils\Auth;
use HackbartPR\Interfaces\Controller;

class LogoutController implements Controller
{
    private Auth $auth;

    public function __construct(Auth $auth)
    {        
        $this->auth = $auth;
    }

    public function processRequest(): void
    {
        $this->auth->logout();
        header('Location: /login');
        exit();
    }
}