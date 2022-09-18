<?php

namespace TaskForce\helpers;

use Yii;
use app\models\User;
use yii\helpers\Html;
use floor12\phone\PhoneFormatter;
use TaskForce\constants\Placeholder;

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

    static public function formatRegistrationDate(User $user): string
    {
        return Yii::$app->formatter
            ->asDate($user->created_at, 'd MMMM, HH:mm');
    }


    static public function getStatus($isBusy = false): string
    {
        return $isBusy ? 'Занят' : 'Открыт для новых заказов';
    }

    static public function isContactsShown(User $user): bool
    {
        $isContactsDefined =
            ($user->phone_number || $user->email || $user->telegram);

        // todo: В случае $user->is_contacts_hidden, этот блок будет виден только пользователям, у которых данный исполнитель был назначен на задание.
        return !$user->is_contacts_hidden && $isContactsDefined;
    }

    static public function getPhoneNumberLink(
        User $user,
        $classNames = ''
    ): string {
        return PhoneFormatter::a(
            $user->phone_number,
            ['class' => $classNames]
        );
    }

    static public function getMailLink(User $user, $classNames = ''): string
    {
        $email = Html::encode($user->email);

        return "<a href=\"mailto:$email\" class=\"$classNames\">$email</a>";
    }

    static public function getTelegramLink(User $user, $classNames = ''): string
    {
        $telegram = Html::encode($user->telegram);

        $domain = $telegram;

        if (str_starts_with($domain, '@')) {
            $domain = substr($domain, 1);
        }

        return "<a href=\"tg://resolve?domain=$domain\" class=\"$classNames\">$telegram</a>";
    }
}

;
