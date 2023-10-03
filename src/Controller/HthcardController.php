<?php

namespace App\Controller;

use App\Entity\Hthcard;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;

class HthcardController extends AbstractController
{

    /*
    #[Route('/hthcard', name: 'app_hthcard')]
    public function index(): Response
    {
        return $this->render('hthcard/index.html.twig', [
            'controller_name' => 'HthcardController',
        ]);
    }
    */


    /**
     * Show a HearthstoneCardbook
     *
     * @param Integer $id (note that the id must be an integer)
     */
    #[Route('/hthcard/{id}', name: 'hthcard_show', requirements: ['id' => '\d+'])]
    public function show(ManagerRegistry $doctrine, $id) : Response
    {
        $hthcardRepository = $doctrine->getRepository(Hthcard::class);
        $hthcard = $hthcardRepository->find($id);

        if (!$hthcard) {
                throw $this->createNotFoundException('The hthcard specified does not exist');
        }
        
        return $this->render('hthcard/show.html.twig',[
            'hthcard' => $hthcard
        ]);

        /*
        // On souhaite donc afficher les informations de l'Hearthstone Cardbook
        $res = "Nom de l'Hearthstone Cardbook : " . $hthcard->getName() . "<br>";

        $res .= "<p>Appartient à : " . $hthcard->getMember() . "<br>";

        $res .= '<p/><a href="' . $this->generateUrl('app_hearthstone_cardbook') . '">Back</a>';

        return new Response('<html><body>'. $res . '</body></html>');
        */
    }
}
