<?php

declare(strict_types=1);

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ContactSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Обратная связь';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <?php
                    if (Yii::$app->user->can('contact/create')) { ?>
                        <div class="row mb-2">
                            <div class="col-md-12">
                                <?= Html::a('Создать обращение', ['create'], ['class' => 'btn btn-success']) ?>
                            </div>
                        </div>
                        <?php
                    } ?>

                    <?php

                    if (Yii::$app->user->can('contact/view')) { ?>
                        <?php
                        Pjax::begin(); ?>
                        <?php
                        // echo $this->render('_search', ['model' => $searchModel]); ?>

                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'filterSelector' => '#myPageSize',
                            'layout' => '{summary}' . Html::activeDropDownList(
                                    $searchModel,
                                    'myPageSize',
                                    [10 => 10, 50 => 50, 100 => 100],
                                    ['id' => 'myPageSize']
                                ) . "{items}<br/>{pager}",
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                'user_id',
                                [
                                    'attribute' => 'Имя Клиента',
                                    'value' => 'user.username'
                                ],
                                [
                                    'attribute' => 'E-mail Клиента',
                                    'value' => 'user.email'
                                ],
                                [
                                    'attribute' => 'Время создания Клиента',
                                    'value' => function ($dataProvider) {
                                        return Yii::$app->formatter->asDatetime($dataProvider->user->created_at);
                                    }
                                ],
                                [
                                    'attribute' => 'Тема сообщения',
                                    'value' => 'title',
                                ],
                                'message:ntext',
                                [
                                    'attribute' => 'line',
                                    'format' => 'raw',
                                    'value' => function ($dataProvider) {
                                        return Html::a('Скачать', $dataProvider->line, ['target' => '_blank']);
                                    }
                                ],
                                'created_at:datetime',

                                ['class' => 'hail812\adminlte3\yii\grid\ActionColumn'],
                            ],
                            'summaryOptions' => ['class' => 'summary mb-2'],
                            'pager' => [
                                'class' => 'yii\bootstrap5\LinkPager',
                            ]
                        ]); ?>

                        <?php
                        Pjax::end(); ?>
                        <?php
                    } ?>
                </div>
                <!--.card-body-->
            </div>
            <!--.card-->
        </div>
        <!--.col-md-12-->
    </div>
    <!--.row-->
</div>
