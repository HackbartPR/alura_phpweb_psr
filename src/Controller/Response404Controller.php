<?php

namespace HackbartPR\Controller;

use HackbartPR\Interfaces\Controller;

class Response404Controller implements Controller
{
    public function processRequest(): void
    {
        http_response_code(404);
    }
}