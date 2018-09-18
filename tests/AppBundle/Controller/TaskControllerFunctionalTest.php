<?php

namespace Tests\AppBundle\Controller;

use AppBundle\Controller\TaskController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerFunctionalTest extends WebTestCase
{
    private $taskcontroller;

    public function testTaskRoute()
    {
        $client = static::createClient();

        $client->request('GET', '/tasks');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}