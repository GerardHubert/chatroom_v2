<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\Conversation;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\JsonEncode;

class ConversationController extends AbstractController
{
    private $em;
    private $userRepo;

    public function __construct(EntityManagerInterface $em, UserRepository $userRepo)
    {
        $this->em = $em;
        $this->userRepo = $userRepo;
    }

    public function addMessageToConversation(Message $message)
    {
        // conversation uniquement liée à l'utilisateur, pas à l'admin
        // Définir à qui lier la conversation (expéditeur ou destinataire)
        $recipient = $message->getRecipient();
        $sender = $message->getSender();

        if (in_array('ROLE_ADMIN', $recipient->getRoles())) {
            $relatesTo = $sender;
        };

        if (in_array('ROLE_ADMIN', $sender->getRoles())) {
            $relatesTo = $recipient;
        }

        // vérifier qu'une conversation n'existe pas déjà pour l'utilisateur
        // si aucune conversation n'existe, on en crée une
        if (!$relatesTo->getConversation()) {
            $conversation = new Conversation;
            $conversation->setRelatesTo($relatesTo);
            $conversation->addMessage($message);

            $this->em->persist($conversation);
            $this->em->flush();
        }

        // s'il ya une conversation, on y ajoute le message
        if ($relatesTo->getConversation() !== null) {
            $conversation = $relatesTo->getConversation();
            $conversation->addMessage($message);
            $this->em->flush();
        }
    }

    /**
     * @Route("/conversation/{id}", name="conversation_json")
     */
    public function getConversationJson($id)
    {
        $user = $this->userRepo->find($id);
        $conversation = $user->getConversation();

        // Si aucune conversation en cours
        if (!$conversation) {
            return new JsonResponse("null");
        }

        // si conversation : on récupère les messages
        $messages = $conversation->getMessages();

        // on formate pour retourner du json
        $data = [];
        foreach ($messages as $key => $message) {
            $data[$key]['content'] = $message->getContent();
            $data[$key]['created_at'] = $message->getCreatedAt();
            $data[$key]['sender'] = $message->getSender()->getUsername();
            $data[$key]['recipient'] = $message->getRecipient()->getUsername();
        }

        return new JsonResponse($data);
    }
}
