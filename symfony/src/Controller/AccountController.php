<?php

namespace App\Controller;

use App\Repository\WorkshopRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    /**
     * @Route("/account", name="app_account")
     */
    public function show(WorkshopRepository $workshopRepository)
    {
        $workshops = $workshopRepository->findAll();

        return $this->render('account/account.html.twig', [
            'workshops' => $workshops,
        ]);
    }
}
