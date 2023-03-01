<?php

namespace HackbartPR\Controller;

use Nyholm\Psr7\Response;
use HackbartPR\Utils\Auth;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LogoutController implements RequestHandlerInterface
{
    use Auth;

    public function __construct()
    {                
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $this->logout();
        return new Response(302, ['Location' => '/login']);        
    }
}