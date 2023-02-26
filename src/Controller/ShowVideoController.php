<?php

namespace HackbartPR\Controller;

use HackbartPR\Utils\Message;
use HackbartPR\Interfaces\Controller;
use HackbartPR\Utils\HtmlView;
use HackbartPR\Repository\PDOVideoRepository;

class ShowVideoController implements Controller
{       
    private PDOVideoRepository $repository;

    use Message;
    use HtmlView;

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