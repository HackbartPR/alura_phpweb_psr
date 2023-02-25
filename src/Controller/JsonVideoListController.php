<?php

namespace HackbartPR\Controller;

use HackbartPR\Entity\Video;
use HackbartPR\Interfaces\Controller;
use HackbartPR\Interfaces\VideoRepository;

class JsonVideoListController implements Controller
{
    private VideoRepository $repository;

    public function __construct(VideoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function processRequest(): void
    {   
        $videoList = array_map(function(Video $video){
            return [
                'id' => $video->id(),
                'title' => $video->title,
                'url' => $video->url,
                'image_path' => '/img/uploads/' . $video->image_path()
            ];
        }, $this->repository->all());

        echo json_encode($videoList);
    }
}