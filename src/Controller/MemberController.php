<?php

namespace App\Controller;


use App\Entity\Member;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;
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
            throw $this->createAccessDeniedException("You must be logged as an ADMIN to access the list of members.");
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

        $hasAccess = ($this->getUser() != null) && ( $this->isGranted('ROLE_ADMIN') || ($this->getUser()->getUserIdentifier() == $member->getUser()->getUsername()) );

        if(!$hasAccess) {
            throw $this->createAccessDeniedException("You cannot access another member's profile !");
        }

        return $this->render('member/show.html.twig', [
            'member' => $member,
        ]);
    }
}
