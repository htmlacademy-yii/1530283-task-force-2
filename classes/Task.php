<?php

require_once 'classes/TaskStatus.php';
require_once 'classes/TaskAction.php';

class Task
{
    private int $customer_id;
    private ?int $contractor_id;
    private string $status;

    public function __construct(
        int $customer_id,
        int $contractor_id = null,
        string $status = TaskStatus::NEW
    ) {
        $this->customer_id = $customer_id;
        $this->contractor_id = $contractor_id;
        $this->status = $status;
    }

    static public function getActionMap(): array
    {
        return [
            TaskAction::CANCEL => 'Отменить',
            TaskAction::RESPONSE => 'Откликнуться',
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

    public function getCustomerAction(): ?string
    {
        if ($this->status === TaskStatus::NEW) {
            return TaskAction::CANCEL;
        }

        if ($this->status === TaskStatus::IN_PROGRESS) {
            return TaskAction::COMPLETE;
        }

        return null;
    }

    public function getContractorAction(): ?string
    {
        if ($this->status === TaskStatus::NEW) {
            return TaskAction::RESPONSE;
        }

        if ($this->status === TaskStatus::IN_PROGRESS) {
            return TaskAction::FAIL;
        }

        return null;
    }

    public function getNextStatus(string $action): ?string
    {
        switch ($action) {
            case TaskAction::CANCEL:
            {
                return $this->status === TaskStatus::NEW ? TaskStatus::CANCELLED
                    : null;
            }

            case TaskAction::RESPONSE:
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
                return null;
            }
        }
    }
}
