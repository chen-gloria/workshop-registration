<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Entity\Workshop;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request as Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\WorkshopRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class WorkshopController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(WorkshopRepository $workshopRepository)
    {
        return $this->render('homepage.html.twig');
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
     * @Route("/workshop/{id}/register", name="instructor_workshop_register", methods="POST")
     */
    public function workshopRegister(UserRepository $userRepository, WorkshopRepository $workshopRepository, Workshop $workshop, 
                                    Request $request, EntityManagerInterface $entityManager)
    {
        $userEmail = $request->getSession()->get('_security.last_username');
        $user = $userRepository->findOneBy(['email' => $userEmail]);

        $user_workshop = $workshopRepository->findWorkshopRegistered($user->getId(), $workshop->getId());

        if (!$user_workshop) {
            $user->addWorkshop($workshop);
            $workshop->addCurrentRegistered();
            $entityManager->flush();

            // Send an email to the User

            // Change the button 
            $this->addFlash('success', 'You have successfully registered this workshop!');
        } else {
            $this->addFlash('success', 'You have already registered this workshop, you can\'t register again!');
        }

        return $this->redirectToRoute('workshop_detail', ['id' => $workshop->getId()]);
    }

    /**
     * @Route("/workshop/{id}/detail", name="workshop_detail")
     */
    public function register(Workshop $workshop): Response
    {
        return $this->render('workshop/show.html.twig', [
            'workshop' => $workshop
        ]);
    }

}
