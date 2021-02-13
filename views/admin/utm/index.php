<?php

use panix\engine\widgets\Pjax;
use panix\engine\grid\GridView;
use panix\engine\Html;


if (!Yii::$app->request->isPjax && !Yii::$app->request->isAjax)
    \yii\helpers\Url::remember();


Pjax::begin([
    'id' => 'pjax-grid-utm'
]);
echo GridView::widget([
    'id' => 'grid-utm',
    'tableOptions' => ['class' => 'table table-striped'],
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'showFooter' => true,
    'footerRowOptions' => ['style' => 'font-weight:bold;', 'class' => 'text-center'],
    'layoutOptions' => [
        'title' => $this->context->pageName
    ],
    'columns' => [
        ['class' => 'panix\engine\grid\columns\CheckboxColumn'],
        'utm_source' => [
            'attribute' => 'utm_source',
            'format' => 'html',
            'contentOptions' => ['class' => 'text-left'],

        ],
        'utm_medium' => [
            'attribute' => 'utm_medium',
            'format' => 'html',
            'contentOptions' => ['class' => 'text-left'],
        ],
        'utm_term' => [
            'attribute' => 'utm_term',
            'format' => 'html',
            'contentOptions' => ['class' => 'text-left'],
        ],
        'utm_campaign' => [
            'attribute' => 'utm_campaign',
            'format' => 'html',
            'contentOptions' => ['class' => 'text-left'],
        ],
        'utm_content' => [
            'attribute' => 'utm_content',
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

