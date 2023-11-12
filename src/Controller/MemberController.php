<?php

namespace App\Controller;


use App\Entity\Member;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;



#[Route('/member')]
#[IsGranted('IS_AUTHENTICATED_FULLY')]
class MemberController extends AbstractController
{
    #[Route('/', name: 'app_member')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $hasAccess = $this->isGranted('ROLE_ADMIN');

        if(!$hasAccess) {
            // throw $this->createAccessDeniedException("You must be logged as an ADMIN to access the list of members.");
            $this->redirectToRoute('error_page', [ 'error_id' => "ADMIN_ONLY" ]);
        }

        $members = $doctrine->getManager()->getRepository(Member::class)->findAll();

        return $this->render('member/index.html.twig', [
            'members' => $members,
        ]);
    }

    #[Route('/{id}', name: 'app_member_show', methods: ['GET'])]
    public function show(ManagerRegistry $doctrine, $id): Response
    {
        $member = $doctrine->getRepository(Member::class)->find($id);

        if($member === null){
            return $this->redirectToRoute('error_page', [ 'error_id' => "UNKNOWN" ]);
        }

        $hasAccess = ( $this->isGranted('ROLE_ADMIN') || ($this->getUser() == $member->getUser()) );

        //dump($hasAccess);

        if(!$hasAccess) {
            // throw $this->createAccessDeniedException("You cannot access another member's profile !");
            return $this->redirectToRoute('error_page', [ 'error_id' => "OWNER_OR_ADMIN" ]);
        }

        return $this->render('member/show.html.twig', [
            'member' => $member,
        ]);
    }
}
