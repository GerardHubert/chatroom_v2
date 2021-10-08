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
     * @Route("/chat/{id}", name="user_chat")
     */
    public function chat($id)
    {
        $user = $this->em->getRepository(User::class)->find($id);

        // transmettre l'id de l'admin
        $users = $this->em->getRepository(User::class)->findAll();

        foreach ($users as $user) {
            if (in_array('ROLE_ADMIN', $user->getRoles())) {
                $adminId = $user->getId();
            };
        }

        return $this->render('user_chat.html.twig', [
            'user' => $user,
            'admin' => $adminId
        ]);
    }
}
