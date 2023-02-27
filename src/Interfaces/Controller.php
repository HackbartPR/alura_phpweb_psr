<?php

namespace HackbartPR\Interfaces;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface Controller
{
    public function processRequest(ServerRequestInterface $request): ResponseInterface;
}