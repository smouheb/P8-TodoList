<?php
/**
 * Created by PhpStorm.
 * User: MacBookAir
 * Date: 29/11/2018
 * Time: 20:51
 */

namespace AppBundle\Security;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UserControl
{
    private $usr;
    private $authorizationchecker;
    private $tokenStorage;

    const OWNER = 'owner';
    const UNKNOWNUSER = 'unknownuser';
    const UNKNOWNADMIN = 'unknownadmin';
    const CONNECTED = 'connected';
    const ANONYMUSER = 2;

    public function __construct(AuthorizationCheckerInterface $authorizationchecker,TokenStorageInterface $tokenStorage)
    {
        $this->authorizationchecker = $authorizationchecker;
        $this->tokenStorage = $tokenStorage;

    }

    public function controlUserRights($iduser)
    {
        //Test whether it is not an anonymous user who is trying to delete a task
        if(!$this->tokenStorage->getToken() instanceof AnonymousToken && !is_null($iduser)){

            $this->usr = $this->tokenStorage->getToken()->getUser()->getId();

            if($iduser == self::ANONYMUSER){

                if($this->authorizationchecker->isGranted('ROLE_ADMIN')) {

                    return self::OWNER;
                }

                return self::UNKNOWNADMIN;

            } elseif($this->usr == $iduser){

                return self::OWNER;
            }
        }
        return self::UNKNOWNUSER;
    }

    public function controlRightsForOtherActions($user)
    {
        //Test whether it is not an anonymous user who is trying to delete a task
        if(!$this->tokenStorage->getToken() instanceof AnonymousToken && !is_null($user)){

                return self::CONNECTED;
            }

        return self::UNKNOWNUSER;
    }

}