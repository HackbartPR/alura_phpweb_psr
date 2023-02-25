<?php

namespace HackbartPR\Controller;

use HackbartPR\Utils\Auth;
use HackbartPR\Interfaces\Controller;

class LogoutController implements Controller
{
    use Auth;

    public function __construct()
    {                
    }

    public function processRequest(): void
    {
        $this->logout();
        header('Location: /login');
        exit();
    }
}