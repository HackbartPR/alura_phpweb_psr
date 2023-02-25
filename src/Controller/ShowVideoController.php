<?php

namespace HackbartPR\Controller;

use HackbartPR\Utils\Message;
use HackbartPR\Interfaces\Controller;
use HackbartPR\Controller\HtmlViewController;
use HackbartPR\Repository\PDOVideoRepository;

class ShowVideoController extends HtmlViewController implements Controller
{       
    private PDOVideoRepository $repository;

    use Message;

    public function __construct(PDOVideoRepository $repository)
    {        
        $this->repository = $repository;
    }

    public function processRequest(): void
    {                
        echo $this->renderTemplate('showVideo', ['videoList' => $this->repository->all()]);
        $this->show();
    }
    
    
}