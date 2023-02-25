<?php

namespace HackbartPR\Controller;

use HackbartPR\Entity\Video;
use HackbartPR\Interfaces\Controller;
use HackbartPR\Interfaces\VideoRepository;

class NewJsonVideoController implements Controller
{
    public function __construct(private VideoRepository $repository)
    {

    }

    public function processRequest(): void
    {
        $request = file_get_contents('php://input');

        $jsonList = json_decode($request, true);

        foreach ($jsonList as $json) {
            $this->repository->save(new Video(null, $json['title'], $json['url'], null));
        }

        http_response_code(201);
    }
}