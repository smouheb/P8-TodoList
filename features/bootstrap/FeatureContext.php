<?php

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension;
use AppBundle\Entity\Task;
use Symfony\Component\Yaml\Yaml;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context
{

    use Symfony2Extension\Context\KernelDictionary;

    /**
     * @return object Entity Manager for subsequent methods/scenarios
     */
    public function getManager()
    {
        $em = $this->getContainer()->get('doctrine')->getManager();

        return $em;
    }

    /**
     * @BeforeScenario
     */
    public function stepsBeforeScenarios()
    {

        $em = $this->getManager();

        // purge the database so that further tests will create tasks by users used in this test
        $em->createQuery('DELETE FROM AppBundle:Task')->execute();

    }

    /**
     * @BeforeScenario
     */
    public function tasksForE2eTesting()
    {

        $test = Yaml::parse(file_get_contents(__DIR__ . '/tasks.yml'));


        foreach ($test as $key => $value){

            $task = new Task();
            $task->setContent($value['content']);
            $task->setTitle($value['title']);

            $em = $this->getManager();
            $em->persist($task);
        }

        $em->flush();
        $em->clear();

    }

    /**
     * @BeforeScenario
     */
    public function allocateRelatedUsers()
    {
        $em = $this->getManager();

        $qb = $em->createQueryBuilder();
        $qb->update('AppBundle:Task', 't')
            ->set('t.user', 2)
            ->where('t.title between :param1 and :param2')
            ->setParameters([
                'param1'=>'TestSma1',
                'param2'=>'TestSma9',
            ])
            ->getQuery()
            ->execute();

        $qb = $em->createQueryBuilder();
        $qb->update('AppBundle:Task', 't')
            ->set('t.user', 6)
            ->where('t.title = :param3')
            ->setParameter('param3','TestSma1')
            ->getQuery()
            ->execute();
    }

    /**
     * @BeforeScenario @changeuser
     */
    public function changeUserBeforeStep()
    {
        $em = $this->getManager();

        $qb = $em->createQueryBuilder();
        $qb->update('AppBundle:Task', 't')
            ->set('t.user', 2)
            ->where('t.title = :param3')
            ->setParameter('param3','TestSma1')
            ->getQuery()
            ->execute();
    }
}
