<?php
// vim:expandtab:sw=4 softtabstop=4:
namespace AppBundle\Security;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserChecker;
use Symfony\Component\Security\Core\User\UserInterface;
/**
 * Class OAuthUserProvider
 * @package AppBundle\Security\Core\User
 */
class OAuthUserProvider extends BaseClass
{
    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $socialID = $response->getUsername();
        $email = $response->getEmail();
        $service = $response->getResourceOwner()->getName();

        $user = null;
        //$test_user = $this->userManager->findUserBy(array($this->getProperty($response)=>$socialID));
        if ($socialID != '') {
            $user = $this->userManager->findUserBy(array($this->getProperty($response)=>$socialID));
        }
        if (null === $user) {
            // user not found, try to find by email
            if ($email == '') {
                throw new UsernameNotFoundException();
            }
            $user = $this->userManager->findUserByEmail($email);

            if (null === $user || !$user instanceof UserInterface) {
                throw new UsernameNotFoundException("no user found with email $email");
                $user = $this->userManager->createUser();
                $user->setEmail($email);
                $user->setPlainPassword(md5(uniqid()));
                $user->setEnabled(true);
            }
            if ($socialID != '') {
                switch ($service) {
                    case 'google':
                        $user->setGoogleId($socialID);
                        break;
                    case 'facebook':
                        $user->setFacebookId($socialID);
                        break;
                    case 'linkedin':
                        $user->setLinkedinId($socialID);
                        break;
                }
            }
            $this->userManager->updateUser($user);
        } else {
            $checker = new UserChecker();
            $checker->checkPreAuth($user);
        }

        return $user;
    }
}
