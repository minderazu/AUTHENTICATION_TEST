<?php
namespace App\Event;

use Symfony\Component\EventDispatcher\Event;
use App\Entity\User;

class UserCreatedEvent extends Event
{
    /**
     * @var User $_user
     */

    private $_user;

    const NAME = "user.created";

    public function __construct(User $user)
    {
        $this->_user = $user;
    }

    public function getUser()
    {
        return $this->_user;
    }
}
