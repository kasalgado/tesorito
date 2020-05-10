<?php declare (strict_types=1);

namespace App\Service;

use Symfony\Component\DependencyInjection\ContainerInterface;
use App\Entity\Chat as ChatEntity;
use App\Entity\User;

class Chat
{
    const NEW_MESSAGE_TRUE = 1;
    const NEW_MESSAGE_FALSE = 0;
    
    private $doctrine;
    private $user;
    
    public function __construct(ContainerInterface $container)
    {
        $this->doctrine = $container->get('doctrine');
        $this->user = $container->get('security.token_storage')->getToken()->getUser();
    }
    
    public function createUserCheckingString(): string
    {
        $checkingUsers = [];

        foreach ($this->doctrine->getRepository(User::class)->findOtherUsers() as $otherUser) {
            $checkingUsers[$otherUser->getId()] = self::NEW_MESSAGE_TRUE;
        }

        return json_encode($checkingUsers);
    }

    public function checkUserNewMessages(array $results): array
    {
        foreach ($results as $result) {
            $chat = $this->doctrine->getRepository(ChatEntity::class)->find($result->getId());
            $userChecking = json_decode($chat->getUserChecking(), true);

            if ($userChecking[$this->user->getId()]) {
                return array_merge(['chats' => $results], $this->checkNewMessages($chat, $userChecking));
            }

            return ['messages' => false];
        }
    }
    
    private function checkNewMessages(ChatEntity $chat, array $userChecking): array
    {
        $userChecking[$this->user->getId()] = self::NEW_MESSAGE_FALSE;
        $chat->setUserChecking(json_encode($userChecking));

        if (!in_array(self::NEW_MESSAGE_TRUE, array_values($userChecking))) {
            $chat->setNewMessage(false);
        }

        $em = $this->doctrine->getManager();
        $em->persist($chat);
        $em->flush();

        return ['as_array' => true, 'messages' => true];
    }
}
