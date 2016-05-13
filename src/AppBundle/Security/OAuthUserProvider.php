<?php
namespace AppBundle\Security;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;
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
        $user = $this->userManager->findUserBy(array($this->getProperty($response)=>$socialID));
        $email = $response->getEmail();
        if (null === $user) {
            $user = $this->userManager->findUserByEmail($email);

            if (null === $user || !$user instanceof UserInterface) {
                $user = $this->userManager->createUser();
                $user->setEmail($email);
                $user->setPlainPassword(md5(uniqid()));
                $user->setEnabled(true);
            }
            $service = $response->getResourceOwner()->getName();
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
            $this->userManager->updateUser($user);
        } else {
            $checker = new UserChecker();
            $checker->checkPreAuth($user);
        }

        return $user;
    }
}
