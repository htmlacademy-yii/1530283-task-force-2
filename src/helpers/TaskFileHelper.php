<?php

namespace TaskForce\helpers;

use app\models\TaskFile;

class TaskFileHelper
{
    const UNITS = ['Б', 'Кб', 'Мб', 'Гб', 'Тб'];

    static public function formatUrl(TaskFile $taskFile): string
    {
        return $taskFile->url . '/' . $taskFile->name;
    }

    static public function formatSize(TaskFile $taskFile, $decimals = 2): string
    {
        $size = $taskFile->size;
        $factor = floor((strlen($size) - 1) / 3);

        return sprintf("%.{$decimals}f", $size / pow(1024, $factor))
               . ' ' . self::UNITS[$factor];
    }
}
