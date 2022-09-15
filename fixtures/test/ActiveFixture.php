<?php

namespace app\fixtures\test;

use yii\test\ActiveFixture as YiiActiveFixture;

class ActiveFixture extends YiiActiveFixture
{
    public function getData()
    {
        $data = [];
        $filteredData = array_filter(parent::getData());
        $index = 0;

        foreach ($filteredData as $value) {
            $key = $this->tableName . $index;
            $data[$key] = $value;
            $index++;
        }

        return $data;
    }
}
