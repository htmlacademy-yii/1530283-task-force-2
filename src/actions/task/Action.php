<?php

namespace TaskForce\actions\task;

use TaskForce\models\TaskHelper;

abstract class Action
{
    public function getName(): string
    {
        return TaskHelper::getActionMap()[$this->getInternalName()];
    }

    abstract public function getInternalName(): string;

    abstract public function checkPermission(
        int $userId,
        int $customerId,
        ?int $contractorId
    ): bool;
}
