<?php

namespace App\Auth;

class Login
{

    private $user;
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function check($user)
    {
        if (!isset($user['password']) or !isset($this->data['password']))
            return false;

        if (password_verify($user['password'], $this->data['password']))
            return true;

        return false;
    }

    public function access()
    {
        $_SESSION['user'] = $this->data;
    }

}