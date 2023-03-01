<?php

namespace HackbartPR\Controller;

use Nyholm\Psr7\Response;
use HackbartPR\Utils\Auth;
use HackbartPR\Utils\Message;
use HackbartPR\Interfaces\Controller;
use HackbartPR\Utils\HtmlView;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LoginController implements Controller
{
    use Auth;
    use Message;
    use HtmlView;

    public function __construct()
    {                
    }

    public function processRequest(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->isLogged()) {
            return new Response(200, ['Location' => '/']);
        }

        $this->show();
        return new Response(200, body: $this->renderTemplate('login'));        
    }
}