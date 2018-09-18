<?php
/**
 * Created by PhpStorm.
 * User: MacBookAir
 * Date: 16/08/2018
 * Time: 07:17
 */

namespace Tests\AppBundle\Controller;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use AppBundle\Form\TaskType;
use AppBundle\Form\UserType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\Test\TypeTestCase;
//use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Mapping\ClassMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FormUnitTest extends TypeTestCase
{
    private $validator;

    public function getExtensions()
    {

        $this->validator = $this->createMock(ValidatorInterface::class);

        $this->validator
             ->method('validate')
             ->will($this->returnValue(new ConstraintViolationList()));

        $this->validator
             ->method('getMetadataFor')
             ->will($this->returnValue(new ClassMetadata(Form::class)));

        return array(
            new ValidatorExtension($this->validator),
        );
    }

    public function testCreateTask()
    {
        $formdata = array(
            'title'=> 'test1',
            'content' => 'testcontent'
        );

       $task = new Task();

       $form = $this->factory->create(TaskType::class, $task);

        $form->submit($formdata);

        $this->assertTrue($form->isSynchronized());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formdata) as $key){

            $this->assertArrayHasKey($key, $children);
        }
    }

    public function testCreateUser()
    {
        $formdata = array(
            'username'=> ['test1'],
            'password' => 'testcontent',
            'email' => 'test@test.com',
            'role' => 'ROLE_USER'
        );

        $user = new User();

        $form = $this->factory->create(UserType::class, $user);

        $form->submit($formdata);

        $this->assertTrue($form->isSynchronized());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formdata) as $key){

            $this->assertArrayHasKey($key, $children);

        }

    }
}