<?php

declare(strict_types=1);

namespace App\Security\Authorization\Voter;

use App\Entity\Category;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CategoryVoter extends Voter
{
    public const CATEGORY_READ = 'CATEGORY_READ';
    public const CATEGORY_CREATE = 'CATEGORY_CREATE';
    public const CATEGORY_UPDATE = 'CATEGORY_UPDATE';
    public const CATEGORY_DELETE = 'CATEGORY_DELETE';

    protected function supports(string $attribute, $subject): bool
    {
        return \in_array($attribute, $this->supportedAttributes(), true);
    }

    /**
     * @param Category|null $subject
     */
    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token)
    {
        /** @var User $tokenUser */
        $tokenUser = $token->getUser();

        if (self::CATEGORY_CREATE === $attribute) {
            return true;
        }

        if (null !== $group = $subject->getGroup()) {
            if (\in_array($attribute, [self::CATEGORY_READ, self::CATEGORY_UPDATE, self::CATEGORY_DELETE], true)) {
                return $tokenUser->isMemberOfGroup($group);
            }
        }

        if (\in_array($attribute, [self::CATEGORY_READ, self::CATEGORY_UPDATE, self::CATEGORY_DELETE], true)) {
            return $subject->isOwnedBy($tokenUser);
        }

        return false;
    }

    private function supportedAttributes(): array
    {
        return [
            self::CATEGORY_READ,
            self::CATEGORY_CREATE,
            self::CATEGORY_UPDATE,
            self::CATEGORY_DELETE,
        ];
    }
}
