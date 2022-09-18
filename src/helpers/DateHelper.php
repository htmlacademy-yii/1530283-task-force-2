<?php

namespace TaskForce\helpers;

use Yii;

class DateHelper
{
    static public function formatFullDate(string $date)
    {
        return Yii::$app->formatter->asDate($date, 'd MMMM, HH:mm');
    }

    static public function formatRelativeDate(string $date)
    {
        return Yii::$app->formatter->asRelativeTime($date);
    }
}
