<?php

use yii\widgets\Pjax;
use panix\engine\grid\GridView;
use panix\engine\Html;


if (!Yii::$app->request->isPjax && !Yii::$app->request->isAjax)
    \yii\helpers\Url::remember();


Pjax::begin([
    'id' => 'pjax-grid-seo',
]);
echo GridView::widget([
    'id'=>'grid-seo',
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'showFooter' => true,
    'footerRowOptions' => ['style' => 'font-weight:bold;', 'class' => 'text-center'],
    'layoutOptions' => [
        'title' => $this->context->pageName
    ],
    'columns' => [
        [
            'class' => 'yii\grid\SerialColumn',
            'contentOptions' => ['class' => 'text-center']
        ],
        'url' => [
            'attribute' => 'url',
            'format' => 'html',
            'contentOptions' => ['class' => 'text-left'],
            'value' => function ($model) {
                return Html::a($model->url, $model->url, ['target' => '_blank','data-pjax'=>'0']);
            }
        ],
        'title' => [
            'attribute' => 'title',
            'format' => 'html',
            'contentOptions' => ['class' => 'text-left'],
        ],
        'description' => [
            'attribute' => 'description',
            'format' => 'html',
            'contentOptions' => ['class' => 'text-left'],
        ],
        [
            'class' => 'panix\engine\grid\columns\ActionColumn',
            'template' => '{update} {switch} {delete}',
        ]
    ]
]);
Pjax::end();

