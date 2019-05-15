<?php

use yii\widgets\Pjax;
use panix\engine\grid\GridView;

if(!Yii::$app->request->isPjax && !Yii::$app->request->isAjax)
    \yii\helpers\Url::remember();


Pjax::begin([
    'id' => 'pjax-container',
]);
echo GridView::widget([
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
        'url:url',
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

