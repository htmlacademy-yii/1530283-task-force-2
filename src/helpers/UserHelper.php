<?php

namespace TaskForce\helpers;

use app\models\User;
use TaskForce\constants\Placeholder;

class UserHelper
{
    static public function ensureAvatarUrl(User $user): string
    {
        return $user->avatar_url ?? Placeholder::USER_AVATAR;
    }
}
