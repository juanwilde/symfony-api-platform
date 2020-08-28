<?php

declare(strict_types=1);

namespace App\Api\Listener\PreWriteListener;

use App\Entity\Category;
use App\Entity\User;
use App\Exception\Category\CannotCreateCategoryForAnotherGroupException;
use App\Exception\Category\CannotCreateCategoryForAnotherUserException;
use App\Exception\Category\UnsupportedCategoryTypeException;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class CategoryPreWriteListener implements PreWriteListener
{
    private const CATEGORY_POST = 'api_categories_post_collection';

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

        if (self::CATEGORY_POST === $request->get('_route')) {
            /** @var Category $category */
            $category = $event->getControllerResult();

            $type = $category->getType();
            if (!\in_array($type, [Category::EXPENSE, Category::INCOME], true)) {
                throw UnsupportedCategoryTypeException::fromType($type);
            }

            if (null !== $group = $category->getGroup()) {
                if (!$tokenUser->isMemberOfGroup($group)) {
                    throw new CannotCreateCategoryForAnotherGroupException();
                }
            }

            if (!$category->isOwnedBy($tokenUser)) {
                throw new CannotCreateCategoryForAnotherUserException();
            }
        }
    }
}
