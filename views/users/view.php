<?php
/**
 * @var View $this
 * @var User $user
 * @var Task $reviewedTasks
 * @var int $completedTasksCount
 * @var int $failedTasksCount
 * @var int|null $age
 */

use yii\web\View;
use app\models\Task;
use app\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use TaskForce\helpers\UserHelper;
use floor12\phone\PhoneFormatter;

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
                <!--                            todo: добавить рейтинг-->
                <div class="card-rate">
                    <div class="stars-rating big"><span
                                class="fill-star">&nbsp;</span><span
                                class="fill-star">&nbsp;</span><span
                                class="fill-star">&nbsp;</span><span
                                class="fill-star">&nbsp;</span><span>&nbsp;</span>
                    </div>
                    <!--                            todo: добавить рейтинг-->
                    <span class="current-rate">4.23</span>
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
            </div>
            <div class="bio">
                <p class="head-info">Био</p>
                <p class="bio-info"><span class="country-info">Россия</span>,
                    <span class="town-info"><?= $user->city->name ?></span>,
                    <?php
                    if ($age): ?>
                        <!--                    todo: добавить склонение лет-->
                        <span class="age-info"><?= $age ?></span> лет
                    <?php
                    else: ?>
                        <?= 'возраст не указан' ?>
                    <?php
                    endif; ?>
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
                        if ($reviewedTask->review->comment): ?>
                            «<?= Html::encode(
                                $reviewedTask->review->comment
                            ) ?>»
                        <?php
                        endif; ?>
                    </p>
                    <p class="task">Задание «<a href="<?=
                        Url::to(['/tasks/view', 'id' => $reviewedTask->id])
                        ?>"
                                                class="link link--small"><?=
                            Html::encode($reviewedTask->title)
                            ?></a>» выполнено</p>
                </div>
                <div class="feedback-wrapper">
                    <!--                            todo: добавить оценку-->
                    <div class="stars-rating small"><span
                                class="fill-star">&nbsp;</span><span
                                class="fill-star">&nbsp;</span><span
                                class="fill-star">&nbsp;</span><span
                                class="fill-star">&nbsp;</span><span>&nbsp;</span>
                    </div>
                    <p class="info-text">
                        <span class="current-time">
                            <?= Yii::$app
                                ->formatter
                                ->asRelativeTime($reviewedTask->created_at) ?>
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
                <!--                            todo: добавить место в рейтинге-->
                <dd>25 место</dd>
                <dt>Дата регистрации</dt>
                <dd><?= Yii::$app->formatter
                        ->asDate($user->created_at, 'dd MMMM, HH:mm') ?></dd>
                <dt>Статус</dt>
                <!--                            todo: добавить статус-->
                <dd>Открыт для новых заказов</dd>
            </dl>
        </div>
        <?php
        if (!$user->is_contacts_hidden
            && (
                $user->phone_number
                || $user->email
                || $user->telegram
            )
        ): ?>
            <div class="right-card white">
                <h4 class="head-card">Контакты</h4>
                <ul class="enumeration-list">
                    <?php
                    if ($user->phone_number): ?>
                        <li class="enumeration-item">
                            <?= PhoneFormatter::a(
                                $user->phone_number,
                                ['class' => 'link link--block link--phone']
                            ) ?>
                        </li>
                    <?php
                    endif; ?>

                    <?php
                    if ($user->email): ?>
                        <li class="enumeration-item">
                            <a href="mailto:<?= $user->email ?>"
                               class="link link--block link--email">
                                <?= Html::encode($user->email) ?>
                            </a>
                        </li>
                    <?php
                    endif; ?>

                    <?php
                    if ($user->telegram): ?>
                        <li class="enumeration-item">
                            <a href="tg://resolve?domain=<?=
                            Html::encode($user->telegram)
                            ?>"
                               class="link link--block link--tg">
                                <?= Html::encode($user->telegram) ?>
                            </a>
                        </li>
                    <?php
                    endif; ?>
                </ul>
            </div>
        <?php
        endif; ?>
    </div>
</main>
