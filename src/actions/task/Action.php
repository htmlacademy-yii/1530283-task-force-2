<?php

namespace TaskForce\actions\task;

use TaskForce\models\Task;

abstract class Action
{
    public function getName(): string
    {
        return Task::getActionMap()[$this->getInternalName()];
    }

    abstract public function getInternalName(): string;

    abstract public function checkPermission(
        int $userId,
        int $customerId,
        ?int $contractorId
    ): bool;
}
