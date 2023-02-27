<?php

namespace HackbartPR\Controller;

use Nyholm\Psr7\Response;
use HackbartPR\Interfaces\Controller;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Response404Controller implements Controller
{
    public function processRequest(ServerRequestInterface $request): ResponseInterface
    {  
        return new Response(404);        
    }
}