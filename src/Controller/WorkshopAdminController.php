<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorkshopAdminController extends AbstractController
{
    /**
     * @Route("/admin/workshop/create", name="admin_workshop_create")
     */
    public function create(): Response
    {
        return $this->render('workshop_admin/create.html.twig');
    }

    /**
     * @Route("/admin/workshop/{id}/edit", name="admin_workshop_edit")
     */
    public function edit(): Response
    {
        return $this->render('workshop_admin/edit.html.twig');
    }

    /**
     * @Route("/admin/workshops", name="admin_workshop_list")
     */
    public function list(): Response
    {
        return $this->render('workshop_admin/list.html.twig');
    }
}
