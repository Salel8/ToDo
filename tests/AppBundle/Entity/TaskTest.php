<?php

namespace Tests\AppBundle\Entity;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class Task extends KernelTestCase
{

    public function getEntity(): Task
    {
        return (new Task())
            ->setTitle('Un titre')
            ->setContent('Contenu du test')
    }

    public function assertHasErrors(Task $code, int $number = 0)
    {
        self::bootKernel();
        $error = self::$container->get('validator')->validate($code);
        $this->assertCount($number, $error);
    }

    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidBlankTitleEntity()
    {
        $this->assertHasErrors($this->getEntity()->setTitle(''), 1);
    }

    public function testInvalidBlankContentEntity()
    {
        $this->assertHasErrors($this->getEntity()->setContent(''), 1);
    }
}