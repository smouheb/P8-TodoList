<?php
/**
 * Created by PhpStorm.
 * User: MacBookAir
 * Date: 29/11/2018
 * Time: 20:51
 */

namespace AppBundle\Security;

use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;

class UserControl
{
    private $usr;
    private $authorizationchecker;
    private $tokenStorage;
    private $usrrole = ['deleteadmin', 'deleterelateduser', 'unknownadmin', 'unknownuser'];

    const ANONYMUSER = 2;

    public function __construct(AuthorizationChecker $authorizationchecker,TokenStorage $tokenStorage)
    {
        $this->authorizationchecker = $authorizationchecker;
        $this->tokenStorage = $tokenStorage;

    }

    public function controlUserRights($iduser)
    {
        //Test whether it is not an anonymous user who is trying to delete a task
        if($this->tokenStorage->getToken() instanceof AnonymousToken){

            return $this->usrrole[3];
        }

        $this->usr = $this->tokenStorage->getToken()->getUser()->getId();

        if($iduser == self::ANONYMUSER){

            if($this->authorizationchecker->isGranted('ROLE_ADMIN'))
            {
                return $this->usrrole[0];
            }

            return $this->usrrole[2];

        } elseif($this->usr == $iduser){


            return $this->usrrole[1];

        }

        return $this->usrrole[3];
    }

}