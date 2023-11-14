<?php

namespace App\Controller;

use App\Entity\Member;
use App\Entity\Deck;
use App\Entity\Hthcard;
use App\Form\DeckType;
use App\Repository\DeckRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


#[Route('/deck')]
class DeckController extends AbstractController
{
    #[Route('/', name: 'app_deck_index', methods: ['GET'])]
    public function index(DeckRepository $deckRepository): Response
    {

        return $this->render('deck/index.html.twig', [
            //'decks' => $deckRepository->findAll(), 
            'decks' => $deckRepository->findBy([ 'public' => true ]), // this is to display ONLY public galleries
        ]);
    }

    #[Route('/new/{id}', name: 'app_deck_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ?Member $member, EntityManagerInterface $entityManager): Response
    {
        if($member === null){
            return $this->redirectToRoute('error_page', [ 'error_id' => "PAGE_NOT_FOUND" ]);
        }

        $hasAccess = $this->isGranted('ROLE_ADMIN') || ($this->getUser() == $member->getUser());

        if(!$hasAccess) {
            return $this->redirectToRoute('error_page', [ 'error_id' => "OWNER_OR_ADMIN" ]);
        }

        $deck = new Deck();
        $deck->setMember($member);

        $form = $this->createForm(DeckType::class, $deck);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($deck);
            $entityManager->flush();

            //return $this->redirectToRoute('app_deck_show', [ 'id' => $deck->getId() ], Response::HTTP_SEE_OTHER);
            return $this->redirectToRoute('app_member_show', [ 'id' => $deck->getMember()->getId() ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('deck/new.html.twig', [
            'deck' => $deck,
            'form' => $form,
            'member' => $member
        ]);
    }

    #[Route('/{id}', name: 'app_deck_show', methods: ['GET'])]
    public function show(Deck $deck): Response
    {
        $hasAccess = $deck->isPublic() || $this->isGranted('ROLE_ADMIN') || ($this->getUser() == $deck->getMember()->getUser());

        if(!$hasAccess) {
            return $this->redirectToRoute('error_page', [ 'error_id' => "OWNER_OR_ADMIN" ]);
        }

        return $this->render('deck/show.html.twig', [
            'deck' => $deck,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_deck_edit', methods: ['GET', 'POST'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function edit(Request $request, Deck $deck, EntityManagerInterface $entityManager): Response
    {

        $hasAccess =
            $this->getUser() !== null &&
            $deck->getMember()->getUser() !== null &&
            ($this->isGranted('ROLE_ADMIN') || ($this->getUser() == $deck->getMember()->getUser()));

        if(!$hasAccess) {
            // throw $this->createAccessDeniedException("You cannot modify another member's cardbook !");
            return $this->redirectToRoute('error_page', [ 'error_id' => "OWNER_OR_ADMIN" ]);
        }

        $form = $this->createForm(DeckType::class, $deck);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            //return $this->redirectToRoute('app_deck_show', [ 'id' => $deck->getId() ], Response::HTTP_SEE_OTHER);
            return $this->redirectToRoute('app_member_show', [ 'id' => $deck->getMember()->getId() ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('deck/edit.html.twig', [
            'deck' => $deck,
            'form' => $form
        ]);
    }

    #[Route('/{id}', name: 'app_deck_delete', methods: ['POST'])]
    public function delete(Request $request, Deck $deck, EntityManagerInterface $entityManager, bool $flush = false): Response
    {
        if ($this->isCsrfTokenValid('delete'.$deck->getId(), $request->request->get('_token'))) {
            
            // $hthcardRepository = $entityManager->getRepository(Hthcard::class);

            // $hthcards = $deck->getCards();
            
            // foreach($hthcards as $hthcard){

            // }

            $entityManager->remove($deck);

            $entityManager->flush();
        }

        return $this->redirectToRoute('app_member_show', [ 'id' => $deck->getMember()->getId() ], Response::HTTP_SEE_OTHER);
    }
    
    
    /**
     * @Route("/{deck_id}/hthcard/{hthcard_id}", name="app_deck_hthcard_show", methods={"GET"})
     * @ParamConverter("deck", options={"id" = "deck_id"})
     * @ParamConverter("hthcard", options={"id" = "hthcard_id"})
     */
    public function hthcardShow(Deck $deck, HthCard $hthcard): Response
    {
        if(! $deck->getCards()->contains($hthcard)) {
            //throw $this->createNotFoundException("Couldn't find such a card in this deck!");
            return $this->redirectToRoute('error_page', [ 'error_id' => "REQUESTED CARD NOT IN PUBLIC DECK" ]);
        }
        
        if( !( $deck->isPublic() || $this->isGranted('ROLE_ADMIN') ) ) {
            //throw $this->createAccessDeniedException("You cannot access the requested ressource!");
            return $this->redirectToRoute('error_page', [ 'error_id' => "OWNER_OR_ADMIN" ]);
        }

        return $this->render('deck/hthcard_show.html.twig', [
            'deck' => $deck,
            'hthcard' => $hthcard
        ]);
    }

}
