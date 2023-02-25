<?php

namespace HackbartPR\Controller;

use HackbartPR\Utils\Auth;
use HackbartPR\Utils\Message;
use HackbartPR\Interfaces\Controller;
use HackbartPR\Controller\HtmlViewController;

class LoginController extends HtmlViewController implements Controller
{
    use Auth;
    use Message;

    public function __construct()
    {                
    }

    public function processRequest(): void
    {
        if ($this->isLogged()) {
            header('Location: /');
            exit();
        }

        echo $this->renderTemplate('login');        
        $this->show();
    }
}