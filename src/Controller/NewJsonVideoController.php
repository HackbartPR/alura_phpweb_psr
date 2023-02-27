<?php

namespace HackbartPR\Controller;

use Nyholm\Psr7\Response;
use HackbartPR\Entity\Video;
use HackbartPR\Interfaces\Controller;
use HackbartPR\Interfaces\VideoRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class NewJsonVideoController implements Controller
{
    public function __construct(private VideoRepository $repository)
    {
    }

    public function processRequest(ServerRequestInterface $request): ResponseInterface
    {
        $body = $request->getParsedBody();        

        foreach ($body as $video) {
            $this->repository->save(new Video(null, $video['title'], $video['url'], null));
        }

        return new Response(201);
    }
}