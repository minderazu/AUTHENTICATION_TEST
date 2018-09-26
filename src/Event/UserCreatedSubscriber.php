<?php

namespace App\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use App\Event\UserCreatedEvent;

class UserCreatedSubscriber implements EventSubscriberInterface
{
    /**
     * @var Swift_Mailer $_mailer
     */

    private $_mailer;

    public function __construct(\Swift_Mailer $mailer)
    {
        $this->_mailer = $mailer;
    }

    public static function getSubscribedEvents()
    {
        return [
            UserCreatedEvent::NAME => 'onUserCreated'
        ];
    }

    public function onUserCreated(UserCreatedEvent $event)
    {
        $user = $event->getUser();

        $message = (new \Swift_Message())
            ->setSubject('Welcome, ' . $user->getUsername() . '!')
            ->setFrom('send@example.com')
            ->setTo($user->getEmail())
            ->setBody('Hi! You can login with your username and password at: http://localhost:8000/login');

        return $this->_mailer->send($message);

        $event->stopPropagation();
    }
}
