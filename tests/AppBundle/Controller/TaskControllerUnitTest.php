<?php

namespace Tests\AppBundle\Controller;


use PHPUnit\Framework\TestCase;
use AppBundle\Controller\TaskController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Form;

class TaskControllerUnitTest extends TestCase
{
    private $form;
    private $taskcontroller;
    private $request;
    private $controller;

    public function setUp()
    {
        $this->form = $this->createMock(Form::class);

        $this->controller = $this->createMock(Controller::class);

        parent::setUp();

    }

    public function requestEntriesForTaskCreation()
    {
        return [
            ['Test1','testcontent1']
        ];
    }

    /**
     * @dataProvider requestEntriesForTaskCreation
     */
    public function testCreateTaskTrue($req)
    {
       $requested =  $this->getMockBuilder(Request::create('/tasks/create', 'POST',[$req]))
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->taskcontroller = $this->createMock(TaskController::class);

        $createtask = $this->taskcontroller;

        $createtask->createAction($requested);

        $this->assertContainsOnly('/tasks',$createtask);

        //call createAction method, then make the form valid true and check whether the addFlash is executed and then return value is right

    }

    public function testCreateTaskFalse()
    {

        $formfalse = $this->form
            ->method('isValid')
            ->will($this->returnValue(self::isFalse()));

        $this->taskcontroller
            ->method('createAction')
            ->with($this->isFalse())
            ->willReturn('task_list');

    }

    public function tearDown()
    {
        parent::tearDown();

        $this->taskcontroller = null;
    }

}