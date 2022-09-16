<?php

namespace TaskForce\helpers;

use app\models\User;
use TaskForce\constants\Placeholder;
use Yii;

class UserHelper
{
    static public function ensureAvatarUrl(User $user): string
    {
        return $user->avatar_url ?? Placeholder::USER_AVATAR;
    }

    static public function formatReviewsCount(int $count): string|false
    {
        return Yii::$app->i18n->messageFormatter->format(
            '{count, plural, =0{# отзывов} one{# отзыв} few{# отзыва} other{# отзывов}}',
            ['count' => $count],
            Yii::$app->language
        );
    }
}
