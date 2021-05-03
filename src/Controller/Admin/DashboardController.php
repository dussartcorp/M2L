<?php

namespace App\Controller\Admin;

use App\Entity\Theme;
use App\Entity\User;
use App\Entity\Atelier;
use App\Entity\Licencie;
use App\Entity\Vacation;
use App\Repository\ThemeRepository;
use App\Repository\AtelierRepository;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{

    protected $uRepo;
    protected $tRepo;
    protected $aRepo;


    public function __construct(UserRepository $uRepo, AtelierRepository $aRepo, ThemeRepository $tRepo)
    {
        $this->uRepo = $uRepo;
        $this->aRepo = $aRepo;
        $this->tRepo = $tRepo;
    }
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig', [
            'users' => $this->uRepo->countUsers(),
            'themes' => $this->tRepo->countThemes(),
            'ateliers' => $this->aRepo->countAteliers(),
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Maison des ligues')
            ->setFaviconPath('../public/assets/');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Tableau de bord', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('Licenciés', 'fas fa-address-card', Licencie::class);
        yield MenuItem::linkToCrud('Ateliers', 'fas fa-address-book', Atelier::class);
        yield MenuItem::linkToCrud('Vacations', 'fas fa-calendar', Vacation::class);
        yield MenuItem::linkToCrud('Thèmes', 'fas fa-archive', Theme::class);
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        $name = $user->getLicencie()->getNom() . ' ' . $user->getLicencie()->getPrenom();
        return parent::configureUserMenu($user)
            ->setName($name)
            ->setGravatarEmail($user->getEmail());
    }
}
