<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * Default App controller.
 *
 * @Route("/")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage", methods={"GET"})
     */ 
    public function indexAction(Request $request)
    {
        $user = $this->getUser();
        if( $user != null )
            return $this->redirectToRoute ('secure');
        
        return $this->render('default/index.html.twig');          
    }
    /**
     * @Route("/logout", name="logout", methods={"GET"})
     */ 
    public function logout(Request $request)
    {
        
    }
    
    /**
     * @Route("/secure", name="secure")
     */ 
    public function secureAction(Request $request)
    {
        $user = $this->getUser();
        /*
        $session = $request->getSession();
        $params = $session->all();
        foreach($params as $k=>$v){
            echo "K: ".$k.": ".$v."<br/>";
        }
        */
        return $this->render('default/secure.html.twig',['user'=>$user]);          
    }
    
    /**
     * @Route("/getapi", name="getapi")
     */ 
    public function getApiAction(Request $request )
    {
        $user = $this->getUser();
        
        $session = $request->getSession();
        $params = $session->all();
        foreach($params as $k=>$v){
            echo "K: ".$k.": ".$v."<br/>";
        }
        
        // 1. We obtain the token for the user.
        //$clientToken = $oauth->getClientCredentials();
        
        /*     
        $request = $http->post('/apicall');
        $request->addHeader('Authorization', 'Bearer '.$accessToken);
        $response = $request->send();
        $responseBody = $response->getBody();
        */
        
        return $this->render('default/getapi.html.twig',[
            'user'=>$user,
            'result'=>$accessToken,
            ]);          
    }
    
}
