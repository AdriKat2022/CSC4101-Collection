<?php

namespace App\Controller\Admin;


use App\Entity\User;
use App\Entity\Member;
use App\Entity\HearthstoneCardbook;
use App\Entity\Deck;
use App\Entity\Hthcard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{

    #[Route('/', name: 'homepage', methods: ['GET'])]
    public function indexAction(){
        return $this->render('index.html.twig',
            []
        );
    }

    #[Route('/mystery-page', name: 'easter', methods: ['GET'])]
    public function indexRoll(){
        return $this->render('egg.html.twig',
            []
        );
    }


    #[Route('/admimdfldzlbicmpvb-control-check-pass', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Hearthstonetavern');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Back to front-end', 'fas fa-arrow-alt-circle-left',"homepage");
        yield MenuItem::section();
        yield MenuItem::linkToCrud('All Users', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('All Members', 'fas fa-user', Member::class);
        yield MenuItem::linkToCrud('All Cardbooks', 'fas fa-book', HearthstoneCardbook::class);
        yield MenuItem::linkToCrud('All Decks', 'fas fa-book', Deck::class);
        yield MenuItem::linkToCrud('All Cards', 'fas fa-list', Hthcard::class);
    }
}
