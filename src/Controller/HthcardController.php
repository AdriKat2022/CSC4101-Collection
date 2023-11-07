<?php

namespace App\Controller;

use App\Entity\Hthcard;
use App\Entity\HearthstoneCardbook;
use App\Form\HthcardType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


#[IsGranted('IS_AUTHENTICATED_FULLY')]
class HthcardController extends AbstractController
{

    // DEPRECATED OR NOT FUNCTIONNAL
    #[Route('/hthcard/new/{id}', name: 'app_hthcard_new_deprecated', methods: ['GET', 'POST'])]
    public function new(Request $request, HearthstoneCardbook $hearthstoneCardbook, EntityManagerInterface $entityManager): Response
    {
        $hthcard = new Hthcard();
        $hthcard->setHearthstoneCardbook($hearthstoneCardbook);

        $form = $this->createForm(HthcardType::class, $hthcard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($hthcard);
            $entityManager->flush();

            $this->addFlash('message',"The Hearthstone Card has been created successfully !");

            return $this->redirectToRoute('hearthstoneCardbook_show', [], Response::HTTP_SEE_OTHER);
        }

        $this->addFlash('error',"Something went wrong while creating the Hearthstone Card.\n Please try again.");


        return $this->render('hearthstone_cardbook/new.html.twig', [
            'hthcard' => $hthcard,
            'form' => $form,
        ]);
    }


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
    }
}
