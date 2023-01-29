<?php

declare(strict_types=1);

/* @var yii\web\View $this */
/* @var string $name */
/* @var string $message */

/* @var Exception $exception */

use yii\helpers\Html;

$this->title = $name;
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="error-page">
    <div class="error-content" style="margin-left: auto;">
        <h3><i class="fas fa-exclamation-triangle text-danger"></i> <?= Html::encode($name) ?></h3>
        <p>
            <?= nl2br(Html::encode($message)) ?>
        </p>
        <p>
            The above error occurred while the Web server was processing your request.
            Please contact us if you think this is a server error. Thank you.
            Meanwhile, you may <?= Html::a('return to dashboard', Yii::$app->homeUrl); ?>
            or try using the search form.
        </p>
    </div>
</div>
