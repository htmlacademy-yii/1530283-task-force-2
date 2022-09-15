<?php

namespace app\fixtures;

use app\fixtures\test\ActiveFixture;

class ReviewFixture extends ActiveFixture
{
    public $tableName = 'reviews';
    public $depends = [TaskFixture::class, UserFixture::class];
}
