<?php

namespace HackbartPR\Controller;

use Nyholm\Psr7\Response;
use HackbartPR\Utils\Message;
use HackbartPR\Interfaces\Controller;
use HackbartPR\Repository\PDOVideoRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RemoveVideoController implements Controller
{
    private Message $message;
    private PDOVideoRepository $repository;

    use Message;

    public function __construct(PDOVideoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function processRequest(ServerRequestInterface $request): ResponseInterface
    {
        [$id, $validation] = $this->validation($request);

        if (!$validation) {
            return new Response(404, ['Location' => '/']);
        }

        $result = $this->repository->remove($id);

        if ($result) {
            $this->create(self::REMOVE_SUCCESS);
            return new Response(204, ['Location' => '/']);
        } else {
            $this->create(self::REMOVE_FAIL);
            return new Response(400, ['Location' => '/']);
        }
    }

    private function validation(ServerRequestInterface $request): array
    {   
        $body = $request->getParsedBody();

        if (empty($body['id'])) {
            $this->create(self::NOT_FOUND);
            $validation = false;
        }

        $id = filter_var($body['id'], FILTER_VALIDATE_INT);        

        return [$id, $validation];        
    }
}