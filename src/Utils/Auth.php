<?php

namespace HackbartPR\Utils;

class Auth
{
    public static function isLogged(): bool
    {
        if (array_key_exists('logged', $_SESSION) && $_SESSION['logged']) {            
            return true;
        }

        return false;
    }

    public static function login(): void
    {
        $_SESSION['logged'] = true;
    }

    public static function logout(): void
    {
        $_SESSION['logged'] = false;
    }    
}