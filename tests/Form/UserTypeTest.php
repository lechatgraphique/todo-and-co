<?php

namespace App\Tests\Form;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Validation;

class UserTypeTest extends TypeTestCase
{
    protected function getExtensions()
    {
        $validator = Validation::createValidator();

        return [
            new ValidatorExtension($validator),
        ];
    }

    public function testSubmitOk()
    {
        $formData = [
            'username' => 'Bastien',
            'password' => ['pass' => '12345', 'confirmPass' => '12345'],
            'email' => 'bastien@mail.com',
            'roles' => ['ROLE_USER']
        ];

        $user = new User();
        $user->setUsername($formData['username']);
        $user->setPassword($formData['password']['pass']);
        $user->setEmail($formData['email']);
        $user->setRoles($formData['roles']);

        $objectToCheck = new User();
        $objectToCheck->setRoles($formData['roles']);

        $form = $this->factory->create(UserType::class, $objectToCheck);
        $form->submit($formData);

        static::assertTrue($form->isSynchronized());
        static::assertEquals($user->getUsername(), $objectToCheck->getUsername());
        static::assertEquals($user->getEmail(), $objectToCheck->getEmail());

        $children = $form->createView()->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
