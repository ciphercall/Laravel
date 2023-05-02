<?php

namespace App\Traits;

trait DetectUsernameType
{
    private function getUsernameType($username)
    {
        if (preg_match('/^\S+@\S+\.\S+$/', $username)) {
            return 'Email';
        } else if (preg_match('/^01[0-9]{9}$/', $username)) {
            return 'Mobile';
        }
        return null;
    }
}
