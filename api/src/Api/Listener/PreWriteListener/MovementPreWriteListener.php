<?php

declare(strict_types=1);

namespace App\Api\Listener\PreWriteListener;

use App\Entity\Movement;
use App\Entity\User;
use App\Exception\Movement\CannotCreateMovementForAnotherGroupException;
use App\Exception\Movement\CannotCreateMovementToAnotherUserException;
use App\Exception\Movement\CannotUseThisCategoryInMovementException;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class MovementPreWriteListener implements PreWriteListener
{
    private const MOVEMENT_POST = 'api_movements_post_collection';
    private const MOVEMENT_PUT = 'api_movements_put_item';

    private TokenStorageInterface $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function onKernelView(ViewEvent $event): void
    {
        /** @var User|null $tokenUser */
        $tokenUser = $this->tokenStorage->getToken()
            ? $this->tokenStorage->getToken()->getUser()
            : null;

        $request = $event->getRequest();

        if (\in_array($request->get('_route'), [self::MOVEMENT_POST, self::MOVEMENT_PUT], true)) {
            /** @var Movement $movement */
            $movement = $event->getControllerResult();

            if (null !== $group = $movement->getGroup()) {
                if (!$tokenUser->isMemberOfGroup($group)) {
                    throw new CannotCreateMovementForAnotherGroupException();
                }

                if (!$movement->getCategory()->belongsToGroup($group)) {
                    throw new CannotUseThisCategoryInMovementException();
                }
            }

            if (!$movement->isOwnedBy($tokenUser)) {
                throw new CannotCreateMovementToAnotherUserException();
            }

            if (!$movement->getCategory()->isOwnedBy($tokenUser)) {
                throw new CannotUseThisCategoryInMovementException();
            }
        }
    }
}
