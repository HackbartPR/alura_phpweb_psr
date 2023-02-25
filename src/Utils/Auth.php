<?php

namespace HackbartPR\Utils;

trait Auth
{
    private function isLogged(): bool
    {
        if (array_key_exists('logged', $_SESSION) && $_SESSION['logged']) {            
            return true;
        }

        return false;
    }

    private function login(): void
    {
        $_SESSION['logged'] = true;
    }

    private function logout(): void
    {
        $_SESSION['logged'] = false;
    }    
}