<?php

namespace Tests\AppBundle\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class User extends KernelTestCase
{

    public function getEntity(): User
    {
        return (new User())
            ->setUsername('Sam')
            ->setPassword('dragon')
            ->setEmail('sam-77@hotmail.fr')
    }

    public function assertHasErrors(User $code, int $number = 0)
    {
        self::bootKernel();
        $error = self::$container->get('validator')->validate($code);
        $this->assertCount($number, $error);
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidBlankUsernameEntity()
    {
        $this->assertHasErrors($this->getEntity()->setUsername(''), 1);
    }

    public function testInvalidBlankEmailEntity()
    {
        $this->assertHasErrors($this->getEntity()->setEmail(''), 1);
    }

    public function testInvalidEmailEntity()
    {
        $this->assertHasErrors($this->getEntity()->setEmail('samir'), 1);
    }

    public function testInvalidUsedEmail()
    {
        //$this->loadFixtureFiles();

        $this->assertHasErrors($this->getEntity()->setEmail('mehal.samir@htmail.fr'), 1);
    }
}