<?php

namespace TaskForce\actions\task;

use TaskForce\constants\TaskAction;

class CancelAction extends Action
{
    public function getInternalName(): string
    {
        return TaskAction::CANCEL;
    }

    public function checkPermission(
        int $userId,
        int $customerId,
        ?int $contractorId
    ): bool {
        return $userId === $customerId && !isset($contractorId);
    }
}
