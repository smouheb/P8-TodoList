<?php

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Symfony2Extension;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * Defines application features from the specific context.
 */
class TaskAllocationContext extends MinkContext implements Context
{

    const SMAEL = 1;
    const SMAELUSER = 6;
    const YO = 3;

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
     * @Then | I should see the id of the :user in the database
     */
    public function iShouldSeeTheIdOfTheInTheDatabase($user)
    {
       $request = $this->getUsernameForTestE2E($user);

       foreach ($request as $req){

           foreach ($req as $key => $value){

               if($value === $user){

                   echo sprintf('User %s and its id have been persisted accordingly', $value);

               } else {

                   throw new Exception( 'Error occured when testing the persistence');
               }

           }

       }

    }

    private function getUsernameForTestE2E($user)
    {
        $em = $this->getManager();

        try{

            switch (!$user == null){

                case ($user == 'Smaeluser'):
                    $val = self::SMAELUSER;
                    break;

                case ($user == 'Yo'):
                    $val = self::YO;
                    break;

                case($user == 'Smael'):
                    $val = self::SMAEL;
                    break;
            }

            $query = $em->createQueryBuilder();

            $query->select(array('distinct u.username'))
                    ->from('AppBundle:Task', 't')
                    ->leftJoin('AppBundle:User', 'u', \Doctrine\ORM\Query\Expr\Join::WITH, 't.user = u.id')
                    ->where("t.user = :user")
                    ->setParameter('user', $val);

        } catch (Exception $e){

            echo 'Error message: '.$e->getMessage(), '\n'.'in line:'.$e->getLine();

        }

        return $query->getQuery()
                     ->getResult();
    }


}
