<?php

namespace App\Controller;


use App\Entity\Member;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/member')]
class MemberController extends AbstractController
{
    #[Route('/', name: 'app_member')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $members = $doctrine->getManager()->getRepository(Member::class)->findAll();

        return $this->render('member/index.html.twig', [
            'members' => $members,
        ]);
    }

    #[Route('/{id}', name: 'app_member_show', methods: ['GET'])]
    public function show(ManagerRegistry $doctrine, $id): Response
    {
        $member = $doctrine->getRepository(Member::class)->find($id);

        return $this->render('member/show.html.twig', [
            'member' => $member,
        ]);
    }
}
