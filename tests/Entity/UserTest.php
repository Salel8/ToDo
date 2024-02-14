<?php

namespace App\Tests\Entity;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
{
    /*public function testValidator()
    {
        $code = (new User())
            ->setUsername('Samir')
            ->setPassword('dragon')
            ->setEmail('samir@hotmail.fr')
            ->setRole('ROLE_USER');
        self::bootkernel();
        $container = static::getContainer();
        $error = $container->get('validator')->validate($code);
        $this->assertCount(0, $error);
    }*/
    
    public function getEntity(): User
    {
        return (new User())
            ->setUsername('Samir')
            ->setPassword('dragon')
            ->setEmail('samir@hotmail.fr')
            ->setRoles(['ROLE_USER']);
    }

    public function assertHasErrors(User $code, int $number = 0)
    {
        self::bootKernel();
        $container = static::getContainer();
        $error = $container->get('validator')->validate($code);
        $this->assertCount($number, $error);
    }

    public function testValidEntityUser()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidBlankUsernameEntityUser()
    {
        $this->assertHasErrors($this->getEntity()->setUsername(''), 1);
    }

    public function testInvalidBlankEmailEntityUser()
    {
        $this->assertHasErrors($this->getEntity()->setEmail(''), 1);
    }

    public function testInvalidEmailEntityUser()
    {
        $this->assertHasErrors($this->getEntity()->setEmail('samir'), 1);
    }

    /*public function testInvalidUsedEmailUser()
    {
        //$this->loadFixtureFiles();

        $this->assertHasErrors($this->getEntity()->setEmail('admin1@hotmail.fr'), 1);
    }*/

    /*public function testInvalidBlankRoleEntityUser()
    {
        $this->assertHasErrors($this->getEntity()->setRoles(''), 1);
    }*/
}