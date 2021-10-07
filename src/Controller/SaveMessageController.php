<?php

namespace App\Controller;

use App\Entity\Message;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class SaveMessageController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em, UserRepository $userRepo)
    {
        $this->em = $em;
        $this->userRepo = $userRepo;
    }

    /**
     * @Route("/addMessage", name="message_add")
     */
    public function addMessage(Request $request)
    {
        // cette route reçoit par ajax, l'id de l'expéditeur, du destinataire et le contenu du message
        $recipientId = $request->request->get('recipient');
        $senderId = $request->request->get('sender');

        //on trouve les destinataires et expéditeur et on réupère le message
        $recipient = $this->userRepo->find($recipientId);
        $sender = $this->userRepo->find($senderId);
        $content = $request->request->get('content');

        // on set notre entité message et on l'enregistre en BDD
        $message = new Message;
        $message->setRecipient($recipient)
            ->setSender($sender)
            ->setContent($content)
            ->setCreatedAt(new DateTime());

        $this->em->persist($message);
        $this->em->flush();

        return new JsonResponse();
    }
}
