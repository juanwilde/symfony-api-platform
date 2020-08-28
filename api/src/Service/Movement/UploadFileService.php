<?php

declare(strict_types=1);

namespace App\Service\Movement;

use App\Entity\Movement;
use App\Entity\User;
use App\Exception\Movement\MovementDoesNotBelongToGroupException;
use App\Exception\Movement\MovementDoesNotBelongToUserException;
use App\Repository\MovementRepository;
use App\Service\File\FileService;
use League\Flysystem\AdapterInterface;
use Symfony\Component\HttpFoundation\Request;

class UploadFileService
{
    private FileService $fileService;
    private MovementRepository $movementRepository;

    public function __construct(FileService $fileService, MovementRepository $movementRepository)
    {
        $this->fileService = $fileService;
        $this->movementRepository = $movementRepository;
    }

    public function uploadFile(Request $request, User $user, string $id): Movement
    {
        $movement = $this->movementRepository->findOneByIdOrFail($id);

        if (null !== $group = $movement->getGroup()) {
            if (!$user->isMemberOfGroup($group)) {
                throw new MovementDoesNotBelongToGroupException();
            }
        }

        if (!$movement->isOwnedBy($user)) {
            throw new MovementDoesNotBelongToUserException();
        }

        $file = $this->fileService->validateFile($request, FileService::MOVEMENT_INPUT_NAME);

        $this->fileService->deleteFile($movement->getFilePath());

        $fileName = $this->fileService->uploadFile(
            $file,
            FileService::MOVEMENT_INPUT_NAME,
            AdapterInterface::VISIBILITY_PRIVATE
        );

        $movement->setFilePath($fileName);

        $this->movementRepository->save($movement);

        return $movement;
    }
}
