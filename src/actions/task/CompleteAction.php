<?php

namespace TaskForce\actions\task;

use TaskForce\constants\TaskAction;

class CompleteAction extends Action
{
    public function getInternalName(): string
    {
        return TaskAction::COMPLETE;
    }

    public function checkPermission(
        int $userId,
        int $customerId,
        ?int $contractorId
    ): bool {
        return $userId === $customerId && isset($contractorId);
    }
}
