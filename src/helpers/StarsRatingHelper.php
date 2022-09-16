<?php

namespace TaskForce\helpers;

class StarsRatingHelper
{

    static public function getStarsRating(float $rating = 0, $additionalClass = ''): string
    {
        $stars = self::getStars($rating);

        return "<div class=\"stars-rating $additionalClass\">$stars</div>";
    }


    static protected function getStars(float $rating = 0): string
    {
        $stars = '';

        foreach (range(1, 5) as $index) {
            $star = self::getStar($index <= round($rating));
            $stars .= $star;
        }

        return $stars;
    }

    static protected function getStar($filled = false): string
    {
        $className = $filled ? 'class="fill-star"' : '';

        return "<span $className >&nbsp;</span>";
    }
}
