<?php

namespace HackbartPR\Controller;

use Nyholm\Psr7\Response;
use HackbartPR\Utils\Message;
use HackbartPR\Repository\PDOVideoRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RemoveVideoController implements RequestHandlerInterface
{
    private Message $message;
    private PDOVideoRepository $repository;

    use Message;

    public function __construct(PDOVideoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        [$id, $validation] = $this->validation($request);

        if (!$validation) {
            return new Response(404, ['Location' => '/']);
        }

        $result = $this->repository->remove($id);

        if ($result) {
            $this->create(self::REMOVE_SUCCESS);
            return new Response(200, ['Location' => '/']);
        } else {
            $this->create(self::REMOVE_FAIL);
            return new Response(400, ['Location' => '/']);
        }
    }

    private function validation(ServerRequestInterface $request): array
    {   
        $query = $request->getQueryParams();
        $validation = true;

        if (empty($query['id'])) {
            $this->create(self::NOT_FOUND);
            $validation = false;
        }

        $id = filter_var($query['id'], FILTER_VALIDATE_INT);        

        return [$id, $validation];        
    }
}