<?php

namespace App\Controller;

use App\Repository\WorkshopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function homepage(WorkshopRepository $workshopRepository)
    {
        $workshops = $workshopRepository->findAll();

        return $this->render('account/account.html.twig', [
            'workshops' => $workshops,
        ]);
    }
}
