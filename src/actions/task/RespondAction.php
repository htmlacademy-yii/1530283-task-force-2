<?php

namespace TaskForce\actions\task;

use TaskForce\constants\TaskAction;

class RespondAction extends Action
{
    public function getInternalName(): string
    {
        return TaskAction::RESPOND;
    }

    public function checkPermission(
        int $userId,
        int $customerId,
        ?int $contractorId
    ): bool {
        return $userId !== $customerId && !isset($contractorId);
    }
}
