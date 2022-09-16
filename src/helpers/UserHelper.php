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

    static public function formatAge(User $user): string
    {
        if (!isset($user->birthdate)) {
            return 'возраст не указан';
        }

        $years = date_diff(date_create($user->birthdate), date_create())->y;

        return Yii::$app->i18n->messageFormatter->format(
            '{years, plural, one{# год} few{# года} other{# лет}}',
            ['years' => $years],
            Yii::$app->language
        );
    }

    static public function isContactsShown(User $user): bool
    {
        return !$user->is_contacts_hidden
               && (
                   $user->phone_number
                   || $user->email
                   || $user->telegram
               );
    }
}
