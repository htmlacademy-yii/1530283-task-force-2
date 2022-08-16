<?php

namespace TaskForce\actions\task;

use TaskForce\constants\TaskAction;

class FailAction extends Action
{
    public function getInternalName(): string
    {
        return TaskAction::FAIL;
    }

    public function checkPermission(
        int $userId,
        int $customerId,
        ?int $contractorId
    ): bool {
        return $userId === $contractorId;
    }
}
