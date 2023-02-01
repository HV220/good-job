<?php

declare(strict_types=1);

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Contact */
/* @var $form yii\bootstrap5\ActiveForm */
?>

<div class="contact-form">

    <?php
    $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'file')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php
    ActiveForm::end(); ?>

</div>
