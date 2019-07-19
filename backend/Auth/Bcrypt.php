<?php

namespace App\Auth;

class Bcrypt
{

    private $cost;

    public function __construct($cost = 12)
    {
        $this->cost = $cost;
    }

    public function setHash($password)
    {
        return password_hash($password, PASSWORD_DEFAULT, ['cost'=>$this->cost]);
    }

}