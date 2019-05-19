<?php
/**
 * @var $form \panix\engine\bootstrap\ActiveForm
 * @var $model \panix\mod\seo\models\SettingsForm
 */
?>

<?= $form->field($model, 'canonical')->checkbox(); ?>
<?= $form->field($model, 'title_prefix'); ?>
<?= $form->field($model, 'nested_url')->checkbox(); ?>
<?= $form->field($model, 'yandex_verification')->hint('&lt;meta name="yandex-verification" content="..." /&gt;'); ?>
