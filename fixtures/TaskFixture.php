<?php

namespace app\fixtures;

use yii\test\ActiveFixture;

use app\models\Task;

class TaskFixture extends ActiveFixture
{
    public $modelClass = Task::class;
}
