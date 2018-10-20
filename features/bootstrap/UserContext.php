<?php

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension;
use AppBundle\Entity\Task;
use Symfony\Component\Yaml\Yaml;

/**
 * Defines application features from the specific context.
 */
class UserContext extends MinkContext implements Context
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
        $qb = $em->createQueryBuilder();
        $qb->delete('AppBundle:User', 'u')
            ->where('u.username = :param')
            ->setParameter('param','TestUserBehat')
            ->getQuery()
            ->execute();

    }

}
