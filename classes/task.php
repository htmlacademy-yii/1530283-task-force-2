<?php

require_once 'classes/task-status.php';
require_once 'classes/task-action.php';

class Task
{
    private Customer $customer;
    private Contractor|null $contractor;
    private string $status;

    public function __construct(
        Customer $customer,
        Contractor $contractor = null,
        string $status = TaskStatus::NEW
    ) {
        $this->customer = $customer;
        $this->contractor = $contractor;
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

    public function getCustomerAction(): string|null
    {
        if ($this->status === TaskStatus::NEW) {
            return TaskAction::CANCEL;
        }

        if ($this->status === TaskStatus::IN_PROGRESS) {
            return TaskAction::COMPLETE;
        }

        return null;
    }

    public function getContractorAction(): string|null
    {
        if ($this->status === TaskStatus::NEW) {
            return TaskAction::RESPONSE;
        }

        if ($this->status === TaskStatus::IN_PROGRESS) {
            return TaskAction::FAIL;
        }

        return null;
    }

    public function getNextStatus(string $action): string | null
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
