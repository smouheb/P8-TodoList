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
    private $usrrole = ['owner', 'unknownadmin', 'unknownuser'];

    const ANONYMUSER = 2;

    public function __construct(AuthorizationChecker $authorizationchecker,TokenStorage $tokenStorage)
    {
        $this->authorizationchecker = $authorizationchecker;
        $this->tokenStorage = $tokenStorage;

    }

    public function controlUserRights($iduser)
    {
        //Test whether it is not an anonymous user who is trying to delete a task
        if(!$this->tokenStorage->getToken() instanceof AnonymousToken){

            $this->usr = $this->tokenStorage->getToken()->getUser()->getId();

            if($iduser == self::ANONYMUSER){

                if($this->authorizationchecker->isGranted('ROLE_ADMIN')) {

                    return $this->usrrole[0];
                }

                return $this->usrrole[1];

            } elseif($this->usr == $iduser){

                return $this->usrrole[0];
            }

        }

        return $this->usrrole[2];
    }

}