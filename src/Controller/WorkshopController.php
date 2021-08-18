<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class WorkshopController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage()
    {
        // TODO: Add another homepage
        return $this->render('workshop/list.html.twig');
    }

    /**
     * @Route("/workshop/{slug}", name="workshop_show")
     */
    public function show($slug)
    {
        return $this->render('workshop/show.html.twig', [
            'slug' => $slug,
        ]);
    }

    /**
     * @Route("/workshop/{slug}/enroll")
     */
    public function enrollWorkshop($slug)
    {
        return $this->render('workshop/enroll.html.twig', [
            'slug' => $slug,
        ]);
    }

    /**
     * @Route("/workshops")
     */
    public function list(): Response
    {
        return $this->render('workshop/list.html.twig');
    }

}
