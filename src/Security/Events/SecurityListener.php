<?php

declare(strict_types=1);

namespace App\Security\Events;

use App\Core\Events\ControllerEvent;
use App\Security\Exception\AuthenticationException;
use App\Security\Security;

class SecurityListener
{
    public function __invoke(ControllerEvent $eventController)
    {
        if (
            $eventController->getController() instanceof SecuredController &&
            null === (new Security())->getUser()
        ) {
            throw new AuthenticationException();
        }
    }
}
