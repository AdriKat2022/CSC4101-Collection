<?php

namespace App\Controller;

use App\Entity\HearthstoneCardbook;
use App\Entity\Member;
use App\Entity\Hthcard;
use App\Repository\HearthstoneCardbookRepository;
use App\Form\HthcardType;
use App\Form\HearthstoneCardbookType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use function PHPUnit\Framework\equalTo;

#[IsGranted('IS_AUTHENTICATED_FULLY')]
class HearthstoneCardbookController extends AbstractController
{
    #[Route('/hearthstoneCardbook/new/{id}', name: 'app_hearthstoneCardbook_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Member $member, EntityManagerInterface $entityManager): Response
    {

        $hasAccess = $this->isGranted('ROLE_ADMIN') || ($this->getUser()->getUserIdentifier() == $member->getUser()->getUsername());

        if(! $hasAccess) {
            throw $this->createAccessDeniedException("You cannot create another member's cardbook !");
        }

        $hearthstoneCardbook = new HearthstoneCardbook();
        $hearthstoneCardbook->setMember($member);

        $form = $this->createForm(HearthstoneCardbookType::class, $hearthstoneCardbook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($hearthstoneCardbook);
            $entityManager->flush();

            $this->addFlash('message',"The Hearthstone Cardbook has been created successfully !");

            //return $this->redirectToRoute('hearthstoneCardbook_show', ['id' => $hearthstoneCardbook->getId()], Response::HTTP_SEE_OTHER);
            return $this->redirectToRoute('app_member_show', [ 'id' => $hearthstoneCardbook->getMember()->getId() ], Response::HTTP_SEE_OTHER);
        }

        $this->addFlash('error',"Something went wrong while creating the Hearthstone Cardbook.\n Please try again.");


        return $this->render('hearthstone_cardbook/new.html.twig', [
            'hearthstoneCardbook' => $hearthstoneCardbook,
            'form' => $form,
            'member' => $member
        ]);
    }
    
    #[Route('/hearthstoneCardbook/hthcard/new/{id}', name: 'app_hthcard_new', methods: ['GET', 'POST'])]
    public function newCard(Request $request, HearthstoneCardbook $hearthstoneCardbook, EntityManagerInterface $entityManager): Response
    {

        $hasAccess = $this->isGranted('ROLE_ADMIN') || ($this->getUser()->getUserIdentifier() == $hearthstoneCardbook->getMember()->getUser()->getUsername());

        if(!$hasAccess) {
            throw $this->createAccessDeniedException("You cannot access another member's cardbook !");
        }

        $hthcard = new Hthcard();
        $hthcard->setHearthstoneCardbook($hearthstoneCardbook);

        $form = $this->createForm(HthcardType::class, $hthcard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($hthcard);
            $entityManager->flush();

            $this->addFlash('message',"The Hearthstone Card has been created successfully !");

            return $this->redirectToRoute('hearthstoneCardbook_show',[
                'id' => $hearthstoneCardbook->getId()
            ],
            Response::HTTP_SEE_OTHER);
        }

        $this->addFlash('error',"Something went wrong while creating the Hearthstone Card.\n Please try again.");


        return $this->render('hthcard/new.html.twig', [
            'hthcard' => $hthcard,
            'form' => $form,
            'hearthstone_cardbook' => $hearthstoneCardbook
        ]);
    }


    
    #[Route('/{id}/edit', name: 'app_hearthstoneCardbook_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, HearthstoneCardbook $hearthstoneCardbook, EntityManagerInterface $entityManager): Response
    {

        $hasAccess = $this->isGranted('ROLE_ADMIN') || ($this->getUser()->getUserIdentifier() == $hearthstoneCardbook->getMember()->getUser()->getUsername());

        if(!$hasAccess) {
            throw $this->createAccessDeniedException("You cannot access another member's cardbook !");
        }

        $form = $this->createForm(HearthstoneCardbookType::class, $hearthstoneCardbook);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            //return $this->redirectToRoute('hearthstoneCardbook_show', ['id' => $hearthstoneCardbook->getId()], Response::HTTP_SEE_OTHER);
            return $this->redirectToRoute('app_member_show', [ 'id' => $hearthstoneCardbook->getMember()->getId() ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hearthstone_cardbook/edit.html.twig', [
            'hearthstone_cardbook' => $hearthstoneCardbook,
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'app_hearthstoneCardbook_delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Request $request, HearthstoneCardbook $hearthstoneCardbook, EntityManagerInterface $entityManager): Response
    {

        $id = $hearthstoneCardbook->getMember()->getId();

        if ($this->isCsrfTokenValid('delete'.$hearthstoneCardbook->getId(), $request->request->get('_token'))) {
            $entityManager->remove($hearthstoneCardbook);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_member_show', [ 'id' => $id ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/hearthstoneCardbook', name: 'hearthstone_cardbook')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $cardbooks = $doctrine->getManager()->getRepository(HearthstoneCardbook::class)->findAll();


        $hasAccess = $this->isGranted('ROLE_ADMIN');

        if(! $hasAccess) {
            throw $this->createAccessDeniedException("You must be logged as an ADMIN to see all cardbooks.");
        }

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
        $hearthstoneCardbook = $doctrine->getRepository(HearthstoneCardbook::class)->find($id);

        if (!$hearthstoneCardbook) {
                throw $this->createNotFoundException('The HearthstoneCardbook does not exist');
        }
        
        $hasAccess = $this->isGranted('ROLE_ADMIN') || ($this->getUser()->getUserIdentifier() == $hearthstoneCardbook->getMember()->getUser()->getUsername());

        if(!$hasAccess) {
            throw $this->createAccessDeniedException("You cannot access another member's cardbook !");
        }
        
        // On souhaite donc afficher les informations de l'Hearthstone Cardbook
        // $res = "Nom de l'Hearthstone Cardbook : " . $hearthstoneCardbook->getName() . "<br>";

        // $res .= "<p>Appartient à : " . $hearthstoneCardbook->getMember() . "<br>";

        // $res .= '<p/><a href="' . $this->generateUrl('hearthstone_cardbook') . '">Back</a>';

        //return new Response('<html><body>'. $res . '</body></html>');

        return $this->render("hearthstone_cardbook/show.html.twig",[
            'hearthstone_cardbook' => $hearthstoneCardbook
        ]);

    }
}
