<?php

namespace HackbartPR\Controller;

use HackbartPR\Utils\Message;
use HackbartPR\Interfaces\Controller;
use HackbartPR\Controller\HtmlViewController;
use HackbartPR\Repository\PDOVideoRepository;

class ShowVideoController extends HtmlViewController implements Controller
{   
    private Message $message;
    private PDOVideoRepository $repository;

    public function __construct(PDOVideoRepository $repository, Message $message)
    {
        $this->message = $message; 
        $this->repository = $repository;
    }

    public function processRequest(): void
    {                
        echo $this->renderTemplate('showVideo', ['videoList' => $this->repository->all()]);
        $this->message->show();
    }
    
    
}