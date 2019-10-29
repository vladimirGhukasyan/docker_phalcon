<?php

use Phalcon\Http\Request;
use Phalcon\Http\Response;
use Phalcon\Mvc\Micro;
use Phalcon\Security;

class Users extends \Phalcon\Mvc\Model
{
    public $id;

    public $login;

    public $password;

    public function initialize()
    {
        $this->setConnectionService('db');
    }
    public function getSource()
    {
        return "users";
    }


}