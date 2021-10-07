<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StartConversationController extends AbstractController
{
    private $userRepo;
    private $em;

    public function __construct(EntityManagerInterface $em, UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
        $this->em = $em;
    }

    /**
     * @Route("/admin/start", name="conversation_start")
     */
    public function start()
    {
        // 1-récupérer les utilisateurs inscrits et les afficher sous forme de tableau
        $users = $this->em->getRepository(User::class)->findAll();
        return $this->render('start.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/chat/{id}", name="chat")
     */
    public function chat($id)
    {
        $user = $this->em->getRepository(User::class)->find($id);
        dd($user);
    }
}
