<?php

namespace HackbartPR\Controller;

use Nyholm\Psr7\Response;
use HackbartPR\Utils\Auth;
use HackbartPR\Utils\Message;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use HackbartPR\Repository\PDOUserRepository;
use Psr\Http\Server\RequestHandlerInterface;

class VerifyLoginController implements RequestHandlerInterface
{    
    private PDOUserRepository $repository;
    
    use Auth;
    use Message;

    public function __construct(PDOUserRepository $repository)
    {
        $this->repository = $repository;        
    }
    
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        [$email, $password, $validation] = $this->validation($request);

        if (!$validation) {
            return new Response(403, ['Location' => '/login']);
        }

        $user = $this->repository->findByEmail($email);
        
        if (!$user) {
            $this->create(self::LOGIN_FAIL);
            return new Response(403, ['Location' => '/login']);
        }

        if (!password_verify($password, $user->password())) {
            $this->create(self::LOGIN_FAIL);
            return new Response(403, ['Location' => '/login']);   
        } 
        
        $this->login();
        $this->create(self::LOGIN_SUCCESS);
        return new Response(200, ['Location' => '/']);
    }
    
    private function validation(ServerRequestInterface $request): array
    {   
        $body = $request->getParsedBody();
        $validation = true;

        if (empty($body['email']) || !isset($body['password'])) {
            $this->create(self::FORM_FAIL);
            $validation = false;
        }

        $email = filter_var($body['email'], FILTER_VALIDATE_EMAIL);
        $password = filter_var($body['password']);
        
        if (!$email) {
            $this->create(self::EMAIL_INVALID);
            $validation = false;
        }

        return [$email, $password, $validation];
    }
}