<?php

namespace App\Tests\Entity;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TaskTest extends KernelTestCase
{

    public function getEntity(): Task
    {
        return (new Task())
            ->setTitle('Un titre')
            ->setContent('Contenu du test')
            ->setAuthor('mehal.samir@hotmail.fr');
    }

    public function assertHasErrors(Task $code, int $number = 0)
    {
        self::bootKernel();
        $container = static::getContainer();
        $error = $container->get('validator')->validate($code);
        $this->assertCount($number, $error);
    }

    public function testValidEntityTask()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidBlankTitleEntityTask()
    {
        $this->assertHasErrors($this->getEntity()->setTitle(''), 1);
    }

    public function testInvalidBlankContentEntityTask()
    {
        $this->assertHasErrors($this->getEntity()->setContent(''), 1);
    }

    public function testInvalidBlankAuthorEntityTask()
    {
        $this->assertHasErrors($this->getEntity()->setAuthor(''), 1);
    }

    //zakaria.eddouh@gmail.com
}