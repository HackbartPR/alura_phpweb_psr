<?php

namespace HackbartPR\Controller;

use HackbartPR\Utils\Auth;
use HackbartPR\Utils\Message;
use HackbartPR\Interfaces\Controller;
use HackbartPR\Controller\HtmlViewController;

class LoginController extends HtmlViewController implements Controller
{
    private Auth $auth;
    private Message $message;

    public function __construct(Message $message, Auth $auth)
    {
        $this->message = $message;
        $this->auth = $auth;
    }

    public function processRequest(): void
    {
        if ($this->auth->isLogged()) {
            header('Location: /');
            exit();
        }

        echo $this->renderTemplate('login');        
        $this->message->show();
    }
}