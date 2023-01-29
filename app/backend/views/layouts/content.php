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
        <?= $content ?>
    </div>
</div>
