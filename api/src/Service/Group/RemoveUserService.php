<?php

declare(strict_types=1);

namespace App\Service\Group;

use App\Entity\User;
use App\Exception\Group\OwnerCannotBeDeletedException;
use App\Exception\Group\UserNotMemberOfGroupException;
use App\Repository\GroupRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class RemoveUserService
{
    private GroupRepository $groupRepository;
    private UserRepository $userRepository;

    public function __construct(GroupRepository $groupRepository, UserRepository $userRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @throws \Throwable
     */
    public function remove(string $groupId, string $userId, User $requester): void
    {
        $group = $this->groupRepository->findOneByIdOrFail($groupId);
        $user = $this->userRepository->findOneByIdOrFail($userId);

        if ($user->equals($requester)) {
            throw new OwnerCannotBeDeletedException();
        }

        if (!$user->isMemberOfGroup($group)) {
            throw new UserNotMemberOfGroupException();
        }

        $this->groupRepository->getEntityManager()->transactional(
            function (EntityManagerInterface $em) use ($group, $user) {
                $group->removeUser($user);
                $user->removeGroup($group);

                $em->persist($group);
            }
        );
    }
}
