<?php

namespace TaskForce\helpers;

use app\models\TaskFile;

class TaskFileHelper
{
    static public function getUrl(TaskFile $taskFile): string
    {
        return $taskFile->url . '/' . $taskFile->name;
    }
}
