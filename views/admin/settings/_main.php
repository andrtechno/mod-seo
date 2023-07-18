<?php

use yii\helpers\Html;

/**
 * @var $form \panix\engine\bootstrap\ActiveForm
 * @var $model \panix\mod\seo\models\SettingsForm
 */

?>

<?= $form->field($model, 'canonical')->checkbox(); ?>
<?= $form->field($model, 'title_prefix'); ?>
<?= $form->field($model, 'nested_url')->checkbox(); ?>
<?= $form->field($model, 'yandex_verification')->hint('Example: d234dc2a1522da2'); ?>
<?= $form->field($model, 'favicon_size')->checkboxList([
    16 => '<link rel="apple-touch-icon" sizes="16x16" href="/favicon-16.png">',
    32 => '<link rel="apple-touch-icon" sizes="32x32" href="/favicon-32.png">',
    57 => '<link rel="apple-touch-icon" sizes="57x57" href="/favicon-57.png">',
    60 => '<link rel="apple-touch-icon" sizes="60x60" href="/favicon-60.png">',
    72 => '<link rel="apple-touch-icon" sizes="72x72" href="/favicon-72.png">',
    76 => '<link rel="apple-touch-icon" sizes="76x76" href="/favicon-76.png">',
    96 => '<link rel="apple-touch-icon" sizes="96x96" href="/favicon-96.png">',
    114 => '<link rel="apple-touch-icon" sizes="114x114" href="/favicon-114.png">',
    120 => '<link rel="apple-touch-icon" sizes="120x120" href="/favicon-120.png">',
    144 => '<link rel="apple-touch-icon" sizes="144x144" href="/favicon-144.png"> & msapplication-TileImage',
    152 => '<link rel="apple-touch-icon" sizes="152x152" href="/favicon-152.png">',
    180 => '<link rel="apple-touch-icon" sizes="180x180" href="/favicon-180.png">',
]); ?>


<div class="form-group row">
    <?= Html::activeLabel($model, 'og_image', ['class' => 'col-sm-4 col-md-4 col-lg-3 col-xl-2 col-form-label']); ?>
    <div class="col-sm-8 col-lg-10">
        <?= Html::activeFileInput($model, 'og_image', ['class' => 'form-control-file']); ?>
        <div class="help-block">Доступные форматы:
            <strong><?= implode(', ', ['jpg', 'jpeg', 'png', 'webp']); ?></strong></div>
        <?= $model->renderOgImage(); ?>
        <?= Html::error($model, 'og_image'); ?>
    </div>
</div>
