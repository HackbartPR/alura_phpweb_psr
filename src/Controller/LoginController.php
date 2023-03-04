<?php

namespace HackbartPR\Controller;

use League\Plates\Engine;
use Nyholm\Psr7\Response;
use HackbartPR\Utils\Auth;
use HackbartPR\Utils\Message;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginController implements RequestHandlerInterface
{
    use Auth;
    use Message;

    public function __construct(private Engine $template)
    {                
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->isLogged()) {
            return new Response(200, ['Location' => '/']);
        }

        $this->show();
        return new Response(200, body: $this->template->render('login'));        
    }
}