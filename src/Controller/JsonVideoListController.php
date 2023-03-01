<?php

namespace HackbartPR\Controller;

use Nyholm\Psr7\Response;
use HackbartPR\Entity\Video;
use HackbartPR\Interfaces\VideoRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;



class JsonVideoListController implements RequestHandlerInterface
{
    private VideoRepository $repository;

    public function __construct(VideoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {   
        $videoList = array_map(function(Video $video){
            return [
                'id' => $video->id(),
                'title' => $video->title,
                'url' => $video->url,
                'image_path' => '/img/uploads/' . $video->image_path()
            ];
        }, $this->repository->all());

        return new Response(200, ['Content-Type' => 'application/json'], json_encode($videoList));        
    }
}