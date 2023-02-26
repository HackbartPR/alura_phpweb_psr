<?php

namespace HackbartPR\Controller;

use HackbartPR\Utils\Auth;
use HackbartPR\Utils\Message;
use HackbartPR\Interfaces\Controller;
use HackbartPR\Utils\HtmlView;

class LoginController implements Controller
{
    use Auth;
    use Message;
    use HtmlView;

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