<?php

namespace App\Controller;

use App\Entity\HearthstoneCardbook;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HearthstoneCardbookController extends AbstractController
{
    #[Route('/hearthstone/cardbook', name: 'app_hearthstone_cardbook')]
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
            $htmlpage .= '<li>'. $cardbook->getName() .'</li>';
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
    /*#[Route('/HearthstoneCardbook/{id}', name: 'HearthstoneCardbook_show', requirements: ['id' => '\d+'])]
    public function show(ManagerRegistry $doctrine, $id)
    {
        $HearthstoneCardbookRepo = $doctrine->getRepository(HearthstoneCardbook::class);
        $HearthstoneCardbook = $HearthstoneCardbookRepo->find($id);

        if (!$HearthstoneCardbook) {
                throw $this->createNotFoundException('The HearthstoneCardbook does not exist');
        }

        $res = '...';
        //...

        $res .= '<p/><a href="' . $this->generateUrl('HearthstoneCardbook_index') . '">Back</a>';

        return new Response('<html><body>'. $res . '</body></html>');
    } */
}
