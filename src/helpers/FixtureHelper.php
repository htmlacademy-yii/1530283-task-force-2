<?php

namespace TaskForce\helpers;

class FixtureHelper
{
    static public function getCombinations(array $array1, array $array2): array
    {
        $combinations = [];

        for ($i = 0; $i < count($array1); $i++) {
            for ($j = 0; $j < count($array2); $j++) {
                $value1 = $array1[$i];
                $value2 = $array2[$j];
                $combinations[] = [$value1, $value2];
            }
        }

        return $combinations;
    }
}
