<?php

namespace HackbartPR\Controller;

use Nyholm\Psr7\Response;
use HackbartPR\Utils\Auth;
use HackbartPR\Interfaces\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LogoutController implements Controller
{
    use Auth;

    public function __construct()
    {                
    }

    public function processRequest(ServerRequestInterface $request): ResponseInterface
    {
        $this->logout();
        return new Response(302, ['Location' => '/login']);        
    }
}