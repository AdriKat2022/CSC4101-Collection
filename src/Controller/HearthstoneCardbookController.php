<?php

namespace App\Controller;

use App\Entity\HearthstoneCardbook;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HearthstoneCardbookController extends AbstractController
{
    #[Route('/hearthstoneCardbook', name: 'app_hearthstone_cardbook')]
    public function index(ManagerRegistry $doctrine): Response
    {

        $htmlpage = '<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Taverne du fun</title>
    </head>
    <body>
        <h1>Liste des Hearthstone Books</h1>
        <p>Voici la collection des différents livres hearthstone :</p>
        <ul>';

        $cardbooks = $doctrine->getManager()->getRepository(HearthstoneCardbook::class)->findAll();

        foreach($cardbooks as $cardbook) {

            $cardbookUrl = $this->generateUrl(
                'hearthstoneCardbook_show',
                ['id' => $cardbook->getId()]);

            $htmlpage .= '<li><a href=' . $cardbookUrl . '>'. $cardbook->getName() .'<a/></li>';
        }
        $htmlpage .= '</ul>';

        $htmlpage .= '</body></html>';

        return new Response(
            $htmlpage,
            Response::HTTP_OK,
            array('content-type' => 'text/html')
            );
    }


    /**
     * Show a HearthstoneCardbook
     *
     * @param Integer $id (note that the id must be an integer)
     */
    #[Route('/hearthstoneCardbook/{id}', name: 'hearthstoneCardbook_show', requirements: ['id' => '\d+'])]
    public function show(ManagerRegistry $doctrine, $id)
    {
        $hearthstoneCardbookRepo = $doctrine->getRepository(HearthstoneCardbook::class);
        $hearthstoneCardbook = $hearthstoneCardbookRepo->find($id);

        if (!$hearthstoneCardbook) {
                throw $this->createNotFoundException('The HearthstoneCardbook does not exist');
        }
        
        // On souhaite donc afficher les informations de l'Hearthstone Cardbook
        $res = "Nom de l'Hearthstone Cardbook : " . $hearthstoneCardbook->getName() . "<br>";

        $res .= "<p>Appartient à : " . $hearthstoneCardbook->getMember() . "<br>";

        $res .= '<p/><a href="' . $this->generateUrl('app_hearthstone_cardbook') . '">Back</a>';

        return new Response('<html><body>'. $res . '</body></html>');
    }
}
