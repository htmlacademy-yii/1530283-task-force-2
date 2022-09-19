<?php

namespace TaskForce\helpers;

use TaskForce\constants\TaskAction;
use TaskForce\constants\TaskStatus;
use TaskForce\actions\task\CancelAction as TaskCancelAction;
use TaskForce\actions\task\RespondAction as TaskRespondAction;
use TaskForce\actions\task\CompleteAction as TaskCompleteAction;
use TaskForce\actions\task\FailAction as TaskFailAction;
use TaskForce\exceptions\task\ActionException as TaskActionException;
use TaskForce\exceptions\task\StatusException as TaskStatusException;

class TaskHelper
{
    public int $customer_id;
    public ?int $contractor_id;
    public string $status;

    public function __construct(
        int $customer_id,
        int $contractor_id = null,
        string $status = TaskStatus::NEW
    ) {
        if (!self::validateStatus($status)) {
            throw new TaskStatusException(
                "$status is not valid status for Task"
            );
        }

        $this->customer_id = $customer_id;
        $this->contractor_id = $contractor_id;
        $this->status = $status;
    }

    static public function getActionMap(): array
    {
        return [
            TaskAction::CANCEL => 'Отменить',
            TaskAction::RESPOND => 'Откликнуться',
            TaskAction::COMPLETE => 'Завершить',
            TaskAction::FAIL => 'Отказаться',
        ];
    }

    static public function getStatusMap(): array
    {
        return [
            TaskStatus::NEW => 'Новое',
            TaskStatus::CANCELLED => 'Отменено',
            TaskStatus::IN_PROGRESS => 'В работе',
            TaskStatus::COMPLETED => 'Выполнено',
            TaskStatus::FAILED => 'Провалено',
        ];
    }

    static private function validateStatus(string $status): bool
    {
        return array_search($status, array_keys(self::getStatusMap()))
               !== false;
    }

    public function getNextStatus(string $action): ?string
    {
        switch ($action) {
            case TaskAction::CANCEL:
            {
                return $this->status === TaskStatus::NEW ? TaskStatus::CANCELLED
                    : null;
            }

            case TaskAction::RESPOND:
            {
                return $this->status === TaskStatus::NEW ? $this->status
                    : null;
            }

            case TaskAction::COMPLETE:
            {
                return $this->status === TaskStatus::IN_PROGRESS
                    ? TaskStatus::COMPLETED : null;
            }

            case TaskAction::FAIL:
            {
                return $this->status === TaskStatus::IN_PROGRESS
                    ? TaskStatus::FAILED : null;
            }

            default:
            {
                throw new TaskActionException(
                    "$action is not valid action for Task"
                );
            }
        }
    }

    public function getAction(int $userId): array
    {
        $isCustomer = $this->customer_id === $userId;

        if ($isCustomer) {
            return $this->getCustomerAction();
        }

        $isNewTask =
            is_null($this->contractor_id) && $this->status === TaskStatus::NEW;
        $isContractor = $this->contractor_id === $userId || $isNewTask;

        if ($isContractor) {
            return $this->getContractorAction();
        }

        return [];
    }

    protected function getCustomerAction(): array
    {
        if ($this->status === TaskStatus::NEW) {
            return [new TaskCancelAction()];
        }

        if ($this->status === TaskStatus::IN_PROGRESS) {
            return [new TaskCompleteAction()];
        }

        return [];
    }

    protected function getContractorAction(): array
    {
        if ($this->status === TaskStatus::NEW) {
            return [new TaskRespondAction()];
        }

        if ($this->status === TaskStatus::IN_PROGRESS) {
            return [new TaskFailAction()];
        }

        return [];
    }
}
