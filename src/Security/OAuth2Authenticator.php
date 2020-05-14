<?php
namespace App\Security;

use App\Entity\User;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserProviderInterface;

use Doctrine\ORM\EntityManagerInterface;

use BeyondBlueSky\OAuth2PKCEClient\DependencyInjection\OAuth2PKCEClientExtension as OAuth2PKCEClient;
use BeyondBlueSky\OAuth2PKCEClient\Security\OAuth2PKCEAuthenticator;

/**
 */
class OAuth2Authenticator extends OAuth2PKCEAuthenticator
{
    private $em;
    
    public function __construct(EntityManagerInterface $em, OAuth2PKCEClient $oauth2 ) {
        $this->em = $em;
        
        parent::__construct($oauth2);
        
    }
    
    public function supports(Request $request): bool{
        return $request->getPathInfo() == '/oauth2/check' && $request->isMethod('GET');
    }
    
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        // With this function we fetch the user's data from the credentials
        $oauthUser = $this->fetchUser($credentials);
    
        $login = $oauthUser->login;
        $user = $this->em->getRepository(User::class)->findOneBy(['email' => $login]);
            
        if (! $user ) {
            // Now we have to adapt to our local User 
            $user = new User();
            $user->setEmail($oauthUser->login);           
            $user->setFullname($oauthUser->name. " ". $oauthUser->surname1. " ". $oauthUser->surname2);
            //$user->setRoles(['ROLE_USER']);
            $this->em->persist($user);
            $this->em->flush();
        }
        return $user;   
    }   
}
