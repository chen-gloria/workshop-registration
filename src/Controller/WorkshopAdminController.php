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

/**
 * @IsGranted("ROLE_ADMIN")
 */
class WorkshopAdminController extends AbstractController
{
    /**
     * @Route("/admin/workshop/create", name="admin_workshop_create")
     */
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createForm(WorkshopFormType::class);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            /** @var Workshop $workshop */
            $workshop = $form->getData();

            $workshop->setStatusCode();

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
    public function edit(EntityManagerInterface $entityManager, Request $request, Workshop $workshop): Response
    {
        $form = $this->createForm(WorkshopFormType::class, $workshop);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($workshop);
            $entityManager->flush();

            $this->addFlash('success', 'This workshop has been updated!');

            return $this->redirectToRoute('admin_workshop_edit', [
                'id' => $workshop->getId(),
            ]);
        }

        return $this->render('workshop_admin/edit.html.twig', [
            'workshopForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/workshop/{id}/remove", name="admin_workshop_remove", methods="POST")
     */
    public function remove(EntityManagerInterface $entityManager, Workshop $workshop): Response
    {
        $entityManager->remove($workshop);
        $entityManager->flush();
        
        $this->addFlash('success', 'This workshop has been removed!');

        return $this->redirectToRoute('app_account');
    }
}
