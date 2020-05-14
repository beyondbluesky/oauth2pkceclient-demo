<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use BeyondBlueSky\OAuth2PKCEClient\Entity\OAuth2Session;
use BeyondBlueSky\OAuth2PKCEClient\DependencyInjection\OAuth2PKCEClientExtension as OAuth2PKCEClient;

/**
 * Default App controller.
 *
 * @Route("/oauth2")
 */
class OAuth2Controller extends AbstractController
{
    
    /**
     * @Route("/login", name="oauth2_login", methods={"GET"})
     */ 
    public function oauthLogin(Request $request, OAuth2PKCEClient $oauth2)
    {
        
        $session = new OAuth2Session();
        $response= $oauth2->getAuthRedirect($session);

        $this->getDoctrine()->getManager()->persist($session);
        $this->getDoctrine()->getManager()->flush();
        
        return $response;
    }
    
    /**
     * @Route("/check", name="oauth2_check", methods={"GET"})
     */ 
    public function oauthRedirect(Request $request)
    {
        $user= $this->getUser();
        if ($user == null ) {
            return new Response(json_encode( ['status' => false, 'message' => "User not found!"] ) );
        } else {
            return $this->redirectToRoute('homepage');
        }
    }
    
}