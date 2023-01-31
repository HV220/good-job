<?php

declare(strict_types=1);

/* @var string $content */
/* @var View $this */

/* @var false|string $assetDir */

use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\web\View;

?>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <?php
                        if (!is_null($this->title)) {
                            echo Html::encode($this->title);
                        } else {
                            echo Inflector::camelize($this->context->id);
                        } ?>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <?php
                    echo Breadcrumbs::widget([
                        'links' => $this->params['breadcrumbs'] ?? [],
                        'options' => [
                            'class' => 'breadcrumb float-sm-right'
                        ]
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="content">

        <?php
        if (Yii::$app->session->hasFlash('success')): ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <?php
                echo Yii::$app->session->getFlash('success'); ?>
            </div>
        <?php
        endif; ?>

        <?php
        if (Yii::$app->session->hasFlash('error')): ?>
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <?php
                echo Yii::$app->session->getFlash('error'); ?>
            </div>
        <?php
        endif; ?>

        <?= $content ?>
    </div>
</div>
