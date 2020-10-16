<?php

namespace App\Tests\Form;

use App\Entity\Task;
use App\Form\TaskType;
use Symfony\Component\Form\Test\TypeTestCase;

class TaskTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $title = 'Test title';
        $content = 'Test Content';

        $formData = [
            'title' => $title,
            'content' => $content
        ];

        $object = new Task();
        $object->setTitle($title);
        $object->setContent($content);

        $objectToCompare = new Task();

        $form = $this->factory->create(TaskType::class, $objectToCompare);
        $form->submit($formData);

        static::assertTrue($form->isSynchronized());

        static::assertEquals($object->getTitle(), $objectToCompare->getTitle());
        static::assertEquals($object->getContent(), $objectToCompare->getContent());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }

    }
}
