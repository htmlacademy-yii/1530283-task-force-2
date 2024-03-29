<?php
/**
 * @var View $this
 * @var User $user
 * @var Task $reviewedTasks
 * @var int $completedTasksCount
 * @var int $failedTasksCount
 * @var int $ratingPosition
 * @var bool $isBusy
 */

use yii\web\View;
use app\models\Task;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use TaskForce\helpers\DateHelper;
use TaskForce\helpers\UserHelper;
use TaskForce\helpers\StarsRatingHelper;

$this->title = 'Профиль исполнителя';
?>

<main class="main-content container">
    <div class="left-column">
        <h3 class="head-main">
            <?= Html::encode($user->name) ?>
        </h3>
        <div class="user-card">
            <div class="photo-rate">
                <img class="card-photo"
                     src="<?= UserHelper::ensureAvatarUrl($user) ?>"
                     width="191"
                     height="190" alt="Фото пользователя">
                <div class="card-rate">
                    <?= StarsRatingHelper::getStarsRating(
                        $user->rating,
                        'big'
                    ) ?>
                    <span class="current-rate">
                        <?= $user->rating ?>
                    </span>
                </div>
            </div>
            <?php
            if ($user->description): ?>
                <p class="user-description">
                    <?= Html::encode($user->description) ?>
                </p>
            <?php
            endif; ?>
        </div>
        <div class="specialization-bio">
            <div class="specialization">
                <p class="head-info">Специализации</p>
                <?php
                if (count($user->categories)): ?>
                    <ul class="special-list">
                        <?php
                        foreach ($user->categories as $category): ?>
                            <li class="special-item">
                                <a href="<?= Url::to(
                                    [
                                        '/tasks/index',
                                        'categories[]' => $category->id
                                    ]
                                ) ?>" class="link link--regular">
                                    <?= $category->name ?>
                                </a>
                            </li>
                        <?php
                        endforeach; ?>
                    </ul>
                <?php
                else: ?>
                    <p class="bio-info">Не указаны</p>
                <?php
                endif; ?>
            </div>
            <div class="bio">
                <p class="head-info">Био</p>
                <p class="bio-info"><span class="country-info">Россия</span>,
                    <span class="town-info"><?= $user->city->name ?></span>,
                    <span class="age-info"><?=
                        UserHelper::formatAge($user) ?></span>
                </p>
            </div>
        </div>

        <h4 class="head-regular">Отзывы заказчиков</h4>

        <?php
        if (!count($reviewedTasks)): ?>
            <p>Нет отзывов</p>
        <?php
        endif; ?>

        <?php
        foreach ($reviewedTasks as $reviewedTask): ?>
            <?php
            $review = $reviewedTask->review; ?>
            <div class="response-card">
                <img class="customer-photo"
                     src="<?= UserHelper::ensureAvatarUrl(
                         $reviewedTask->customer
                     ) ?>"
                     width="120"
                     height="127" alt="Фото заказчиков">
                <div class="feedback-wrapper">
                    <p class="feedback">
                        <?php
                        if ($review->comment): ?>
                            «<?= Html::encode($review->comment) ?>»
                        <?php
                        endif; ?>
                    </p>
                    <p class="task">Задание «<a href="<?=
                        Url::to(['/tasks/view', 'id' => $reviewedTask->id])
                        ?>" class="link link--small"><?=
                            Html::encode($reviewedTask->title)
                            ?></a>» выполнено</p>
                </div>
                <div class="feedback-wrapper">
                    <?= StarsRatingHelper::getStarsRating(
                        $review->rate,
                        'small'
                    ) ?>
                    <p class="info-text">
                        <span class="current-time">
                            <?= DateHelper::formatRelativeDate(
                                $reviewedTask->created_at
                            ) ?>
                        </span>
                    </p>
                </div>
            </div>
        <?php
        endforeach; ?>
    </div>
    <div class="right-column">
        <div class="right-card black">
            <h4 class="head-card">Статистика исполнителя</h4>
            <dl class="black-list">
                <dt>Всего заказов</dt>
                <dd><?= $completedTasksCount ?> выполнено,
                    <?= $failedTasksCount ?> провалено
                </dd>
                <dt>Место в рейтинге</dt>
                <dd><?= $ratingPosition ?> место</dd>
                <dt>Дата регистрации</dt>
                <dd><?= DateHelper::formatFullDate($user->created_at) ?></dd>
                <dt>Статус</dt>
                <dd><?= UserHelper::getStatus($isBusy) ?></dd>
            </dl>
        </div>
        <?php
        if (UserHelper::isContactsShown($user)): ?>
            <div class="right-card white">
                <h4 class="head-card">Контакты</h4>
                <ul class="enumeration-list">
                    <?php
                    if ($user->phone_number): ?>
                        <li class="enumeration-item">
                            <?= UserHelper::getPhoneNumberLink(
                                $user,
                                'link link--block link--phone'
                            ) ?>
                        </li>
                    <?php
                    endif; ?>

                    <?php
                    if ($user->email): ?>
                        <li class="enumeration-item">
                            <?= UserHelper::getMailLink(
                                $user,
                                'link link--block link--email'
                            ) ?>
                        </li>
                    <?php
                    endif; ?>

                    <?php
                    if ($user->telegram): ?>
                        <li class="enumeration-item">
                            <?= UserHelper::getTelegramLink(
                                $user,
                                'link link--block link--tg'
                            ) ?>
                        </li>
                    <?php
                    endif; ?>
                </ul>
            </div>
        <?php
        endif; ?>
    </div>
</main>
