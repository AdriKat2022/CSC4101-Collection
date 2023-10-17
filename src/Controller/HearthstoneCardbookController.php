<?php

namespace App\Controller;

use App\Entity\HearthstoneCardbook;
use App\Form\HearthstoneCardbookType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HearthstoneCardbookController extends AbstractController
{

    #[Route('/hearthstonecardbook/new', name: 'app_hearthstoneCardbook_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $hearthstoneCardbook = new HearthstoneCardbook();
        $form = $this->createForm(HearthstoneCardbookType::class, $hearthstoneCardbook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($hearthstoneCardbook);
            $entityManager->flush();

            return $this->redirectToRoute('hearthstone_cardbook', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hearthstone_cardbook/new.html.twig', [
            'hearthstoneCardbook' => $hearthstoneCardbook,
            'form' => $form,
        ]);
    }



    #[Route('/{id}/edit', name: 'app_hearthstoneCardbook_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, HearthstoneCardbook $hearthstoneCardbook, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HearthstoneCardbookType::class, $hearthstoneCardbook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_hearthstoneCardbook_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hearthstone_cardbook/edit.html.twig', [
            'hearthstoneCardbook' => $hearthstoneCardbook,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hearthstoneCardbook_delete', methods: ['POST'])]
    public function delete(Request $request, HearthstoneCardbook $hearthstoneCardbook, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hearthstoneCardbook->getId(), $request->request->get('_token'))) {
            $entityManager->remove($hearthstoneCardbook);
            $entityManager->flush();
        }

        return $this->redirectToRoute('hearthstone_cardbook', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/hearthstoneCardbook', name: 'hearthstone_cardbook')]
    public function index(ManagerRegistry $doctrine): Response
    {
        /*
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
        */
        $cardbooks = $doctrine->getManager()->getRepository(HearthstoneCardbook::class)->findAll();

        /*
        foreach($cardbooks as $cardbook) {

            $cardbookUrl = $this->generateUrl(
                'hearthstoneCardbook_show',
                ['id' => $cardbook->getId()]);

            $htmlpage .= '<li><a href=' . $cardbookUrl . '>'. $cardbook->getName() .'<a/></li>';
        }
        $htmlpage .= '</ul>';

        $htmlpage .= '</body></html>';

        /*
        return new Response(
            $htmlpage,
            Response::HTTP_OK,
            array('content-type' => 'text/html')
            );
            */
        
            return $this->render("hearthstone_cardbook/index.html.twig",[
                'hearthstone_cardbooks' => $cardbooks
            ]);
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

        $res .= '<p/><a href="' . $this->generateUrl('hearthstone_cardbook') . '">Back</a>';

        //return new Response('<html><body>'. $res . '</body></html>');

        return $this->render("hearthstone_cardbook/show.html.twig",[
            'hearthstone_cardbook' => $hearthstoneCardbook
        ]);

    }
}
