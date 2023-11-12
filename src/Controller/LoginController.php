<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{

    #[Route('/admin', name: 'check_admin', methods: ['GET'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function checkAdmin(): Response
    {
        if(! $this->isGranted('ROLE_ADMIN')){
            return $this->redirectToRoute("error_page",[
                "error_id" => "ADMIN_ONLY"
            ]);
        }
        
        return $this->redirectToRoute("admin");
    }


    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
            // get the login error if there is one
            $error = $authenticationUtils->getLastAuthenticationError();

            // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();

            return $this->render('login/index.html.twig', [
                    'last_username' => $lastUsername,
                    'error'         => $error,
            ]);
    }

    #[Route('/logout', name: 'app_logout', methods: ['GET', 'POST'])]
    public function logout()
    {
        // controller can be blank: it will never be called!
        // throw new \Exception('Don\'t forget to activate logout in security.yaml');
        return new Response();
    }

    #[Route('/error_page/{error_id}', name: 'error_page', methods: ['GET'])]
    public function error($error_id){

        $error_msg = '';

        switch($error_id){
            case 'ADMIN_ONLY':
                $error_msg = "You must be logged in as an admin of the tavern to access this content.";
                break;
            case 'OWNER_OR_ADMIN':
                $error_msg = "You must own this content or be logged in as an admin of the tavern to access this content.";
                break;
            default:
                $error_msg = "A war broke out inside the tavern ! We honestly don't know how it started. What have you done ?";
        }

        return $this->render('error.html.twig', [
            'error_msg' => $error_msg,
            'error_origin' => $error_id
        ]);
    }

}