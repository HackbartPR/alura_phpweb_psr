<?php

namespace HackbartPR\Controller;

use HackbartPR\Utils\Auth;
use HackbartPR\Utils\Message;
use HackbartPR\Repository\PDOUserRepository;

class VerifyLoginController
{    
    private PDOUserRepository $repository;
    
    use Auth;
    use Message;

    public function __construct(PDOUserRepository $repository)
    {
        $this->repository = $repository;        
    }
    
    public function processRequest(): void
    {
        [$email, $password] = $this->validation();
        $user = $this->repository->findByEmail($email);
        
        if (!$user) {
            $this->create(self::LOGIN_FAIL, '/login');
        }

        if (!password_verify($password, $user->password())) {
            $this->create(self::LOGIN_FAIL, '/login');            
        } 
        
        $this->login();
        $this->create(self::LOGIN_SUCCESS);
    }
    
    private function validation(): array
    {
        if (!isset($_POST['email']) || !isset($_POST['password'])) {
            $this->create(self::FORM_FAIL, '/login');
        }

        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $password = $_POST['password'];
        
        if (!$email) {
            $this->create(self::EMAIL_INVALID, '/login');
        }

        return [$email, $password];
    }
}