<?php

use panix\mod\seo\models\SeoUrl;
use panix\engine\Html;


if ($model->isNewRecord) {
    $modelseo = new SeoUrl;
} else {
    $modelseo = SeoUrl::find()->where(['url' => Yii::$app->urlManager->createUrl($model->getUrl())])->one();
    if (!$modelseo) {
        $modelseo = new SeoUrl;
    }
}

?>

<div class="form-group row">
    <div class="col-sm-4 col-lg-2"><?= Html::activeLabel($modelseo, 'title', ['class' => 'col-form-label']); ?></div>
    <div class="col-sm-8 col-lg-10">
        <?= Html::activeTextInput($modelseo, 'title', ['class' => 'form-control']); ?>
        <?= Html::error($modelseo, 'title'); ?>
    </div>
</div>
<div class="form-group row">
    <div class="col-sm-4 col-lg-2"><?= Html::activeLabel($modelseo, 'description', ['class' => 'col-form-label']); ?></div>
    <div class="col-sm-8 col-lg-10">
        <?= Html::activeTextarea($modelseo, 'description', ['class' => 'form-control']); ?>
        <?= Html::error($modelseo, 'description'); ?>
    </div>
</div>

<div class="form-group row">
    <div class="col-sm-4 col-lg-2"><?= Html::activeLabel($modelseo, 'h1', ['class' => 'col-form-label']); ?></div>
    <div class="col-sm-8 col-lg-10">
        <?= Html::activeTextInput($modelseo, 'h1', ['class' => 'form-control']); ?>
        <?= Html::error($modelseo, 'h1'); ?>
    </div>
</div>


<div class="form-group row">
    <div class="col-sm-4 col-lg-2"><?= Html::activeLabel($modelseo, 'text', ['class' => 'col-form-label']); ?></div>
    <div class="col-sm-8 col-lg-10">
        <?php
        echo \panix\ext\tinymce\TinyMce::widget([
            'model' => $modelseo,
            'attribute' => 'text'
        ]);
        ?>
    </div>
</div>


<div class="form-group row">
    <div class="col-sm-4 col-lg-2"><?= Html::activeLabel($modelseo, 'meta_robots', ['class' => 'col-form-label2']); ?></div>
    <div class="col-sm-8 col-lg-10">
        <?= Html::activeCheckboxList($modelseo, 'meta_robots', [
            'index' => 'index',
            'follow' => 'follow',
            'noindex' => 'noindex',
            'nofollow' => 'nofollow'
        ], ['class' => 'form-control']); ?>
        <?= Html::error($modelseo, 'meta_robots'); ?>
    </div>
</div>
