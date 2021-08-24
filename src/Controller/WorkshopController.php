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
        /**
         * Find all users registered under this workshop (using $workshopId).
         * @return Workshop[] Returns a Workshop object
         */
        $workshop_users = $workshopRepository->findUsersRegisteredByWorkshopId($workshop->getId())[0];

        /**
         * @return User[] Returns an array of User objects
         */
        $users = $workshop_users->getUsers()->getValues();

        /**
         * Get currently logged in User email, then find the current user
         * @return User[] Returns current User object
         */ 
        $userEmail = $request->getSession()->get('_security.last_username');
        $user = $userRepository->findOneBy(['email' => $userEmail]);

        /**
         * Check if users array contains the current user.
         */
        
        if (!in_array($user, $users)) {

            /** 
             * Add workshop to the user by saving the user_id 
             * and workshop_id to the database table: 'user_workshop' 
             */
            $user->addWorkshop($workshop);
            /** 
             * Add current_registered by 1
             */
            $workshop->addCurrentRegistered();
            $entityManager->flush();

            $this->addFlash('success', 'You have successfully registered this workshop!');

        } else {
            $this->addFlash('success', 'You have already registered this workshop, you can\'t register again!');
        }

        return $this->redirectToRoute('app_account');
    }

    /**
     * @Route("/workshops")
     */
    public function list(): Response
    {
        return $this->render('workshop/list.html.twig');
    }

}
