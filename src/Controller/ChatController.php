<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Chat as ChatEntity;
use App\Service\Chat;
use App\Service\Observer;
use App\Repository\ChatRepository;

class ChatController extends AbstractController
{
    /**
     * @Route("/chat/message/send", name="_chat_message_send", methods={"POST"})
     * @Template("/chat/fetch-messages.html.twig")
     */
    public function setNewMessage(Request $request, Chat $chat, Observer $observer, EntityManagerInterface $em): array
    {
        $chatEntity = new ChatEntity();
        $chatEntity->setUser($this->getUser());
        $chatEntity->setChatText($request->get('message'));
        $chatEntity->setNewMessage(true);
        $chatEntity->setUserChecking($chat->createUserCheckingString());

        $em->persist($chatEntity);
        $em->flush();

        $observer->update('chat');

        return [
            'chat' => $chatEntity,
            'as_array' => false,
            'messages' => true,
        ];
    }
    
    /**
     * @Route("/chat/message/append", name="_chat_message_append", methods={"POST"})
     * @Template("/chat/fetch-messages.html.twig")
     */
    public function fetchMessages(Chat $chat)
    {
        $results = $this->repository()->findByUser($this->getUser(), true);

        if (empty($results)) {
            return ['messages' => false];
        } else {
            return $chat->checkUserNewMessages($results);
        }
    }
    
    private function repository(): ChatRepository
    {
        return $this->getDoctrine()->getRepository(ChatEntity::class);
    }
}
