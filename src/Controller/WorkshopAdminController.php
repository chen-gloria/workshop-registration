<?php

namespace App\Controller;

use App\Entity\Workshop;
use App\Form\WorkshopFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class WorkshopAdminController extends AbstractController
{
    /**
     * @Route("/admin/workshop/create", name="admin_workshop_create")
     * @IsGranted("ROLE_ADMIN")
     */
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(WorkshopFormType::class);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            /** @var Workshop $workshop */
            $workshop = $form->getData();

            $entityManager->persist($workshop);
            $entityManager->flush();

            $this->addFlash('success', 'This workshop has been created!');

            return $this->redirectToRoute('app_account');
        }

        return $this->render('workshop_admin/create.html.twig', [
            'workshopForm' => $form->createView(),
        ]);
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
