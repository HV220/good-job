<?php

declare(strict_types=1);

/* @var View $this */

/* @var LoginForm $model */

use common\models\LoginForm;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

?>
<div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Авторизуйтесь, чтобы использовать приложение</p>

        <?php
        $form = ActiveForm::begin(['id' => 'login-form']) ?>

        <?= $form->field($model, 'email', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-envelope"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])->label(false)->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>

        <?= $form->field($model, 'password', [
            'options' => ['class' => 'form-group has-feedback'],
            'inputTemplate' => '{input}<div class="input-group-append"><div class="input-group-text"><span class="fas fa-lock"></span></div></div>',
            'template' => '{beginWrapper}{input}{error}{endWrapper}',
            'wrapperOptions' => ['class' => 'input-group mb-3']
        ])->label(false)->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <div class="row">
            <div class="col-8">
                <?= $form->field($model, 'rememberMe')->checkbox([
                    'template' => '<div class="icheck-primary">{input}{label}</div>',
                    'labelOptions' => [
                        'class' => ''
                    ],
                    'uncheck' => null
                ]) ?>
            </div>
            <div class="col-4">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary btn-block']) ?>
            </div>
            <div class="col-4">
                <?= Html::a('Регистрация', ['site/registration'], ['class' => 'btn btn-primary']) ?>
            </div>
        </div>

        <?php
        ActiveForm::end(); ?>
        <!-- /.social-auth-links -->
    </div>
    <!-- /.login-card-body -->
</div>
