<?php

declare(strict_types=1);

/* @var View $this */

/* @var false|string $assetDir */

use hail812\adminlte\widgets\Menu;
use yii\web\View;

?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="/index.php" class="brand-link">

        <span class="brand-text font-weight-light">GOOD Технологии</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <?php
            echo Menu::widget([
                'items' => [
                    [
                        'label' => 'Главная страница',
                        'url' => ['/index.php'],
                        'icon' => 'tachometer-alt',
                    ],
                    [
                        'label' => 'Обратная связь',
                        'url' => ['contact/index'],
                        'icon' => 'tachometer-alt',
                        'visible' => Yii::$app->user->can('contact/index')
                    ],
                    ['label' => 'Панель управления', 'header' => true, 'visible' => Yii::$app->user->can('Developer')],
                    [
                        'label' => 'assignment',
                        'url' => ['rbac/assignment'],
                        'icon' => 'tachometer-alt',
                        'visible' => Yii::$app->user->can('Developer')
                    ],
                    [
                        'label' => 'permission',
                        'url' => ['rbac/permission'],
                        'icon' => 'tachometer-alt',
                        'visible' => Yii::$app->user->can('Developer')
                    ],
                    [
                        'label' => 'role',
                        'url' => ['rbac/role'],
                        'icon' => 'tachometer-alt',
                        'visible' => Yii::$app->user->can('Developer')
                    ],
                    [
                        'label' => 'route',
                        'url' => ['rbac/route'],
                        'icon' => 'tachometer-alt',
                        'visible' => Yii::$app->user->can('Developer')
                    ],
                    [
                        'label' => 'rule',
                        'url' => ['rbac/rule'],
                        'icon' => 'tachometer-alt',
                        'visible' => Yii::$app->user->can('Developer')
                    ],
                    ['label' => 'Профиль', 'header' => true],
                    [
                        'label' => 'Авторизация',
                        'url' => ['site/login'],
                        'icon' => 'sign-in-alt',
                        'visible' => Yii::$app->user->isGuest
                    ],
                    [
                        'label' => 'Регистрация',
                        'url' => ['site/registration'],
                        'visible' => Yii::$app->user->isGuest
                    ],
                    [
                        'label' => 'Logout',
                        'url' => ['site/logout'],
                        'icon' => 'sign-in-alt',
                        'visible' => !Yii::$app->user->isGuest
                    ],
                ],
            ]); ?>
</aside>
