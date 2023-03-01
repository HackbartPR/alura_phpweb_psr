<?php

namespace HackbartPR\Controller;

use Nyholm\Psr7\Response;
use HackbartPR\Utils\Auth;
use HackbartPR\Utils\Message;
use HackbartPR\Utils\HtmlView;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginController implements RequestHandlerInterface
{
    use Auth;
    use Message;
    use HtmlView;

    public function __construct()
    {                
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->isLogged()) {
            return new Response(200, ['Location' => '/']);
        }

        $this->show();
        return new Response(200, body: $this->renderTemplate('login'));        
    }
}