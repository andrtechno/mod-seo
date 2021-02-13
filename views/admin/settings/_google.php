<?php
/**
 * @var $form \panix\engine\bootstrap\ActiveForm
 * @var $model \panix\mod\seo\models\SettingsForm
 */
?>

<?= $form->field($model, 'google_site_verification')->hint('&lt;meta name="google-site-verification" content="..." /&gt;'); ?>

<?= $form->field($model, 'google_tag_manager')
    ->hint('Example: GTM-ABC1234')
    ->textInput(['maxlength' => 11]); ?>

<?= $form->field($model, 'google_tag_manager_js')
    ->textarea(['rows' => 5])
    ->hint('<code>{code}</code> - GTM-ABC1234');; ?>

<?= $form->field($model, 'google_analytics_id')
    ->hint('Example: UA-1234567-00')
    ->textInput(['maxlength' => 15]); ?>

<?= $form->field($model, 'google_analytics_js')
    ->textarea(['rows' => 6])
    ->hint('<code>{code}</code> - UA-1234567-00'); ?>

