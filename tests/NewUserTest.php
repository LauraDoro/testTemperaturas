<?php

namespace App\Test;

use App\Entity\User;
use PHPUnit\Framework\TestCase;


class NewUserTest extends TestCase
{
    public function testAdd()
    {
        $user = new User();
        $user->setUsername("Sara");
        $user->setPassword("1234");
        $user->setContador(0);
        $user->setBloqueado(false);
        return $user;
    }
}
