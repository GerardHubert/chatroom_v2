<?php

namespace App\Controller;

use App\Entity\Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ConversationController extends AbstractController
{
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

        // vérifie qu'une conversation n'existe pas déjà pour l'utilisateur
        // si aucune conversation n'existe, on en créer une
        // s'il ya une conversation, on y ajoute le message
    }
}
