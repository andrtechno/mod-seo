<?php
/**
 * @var $form \panix\engine\bootstrap\ActiveForm
 * @var $model \panix\mod\seo\models\SettingsForm
 */
?>
<div class="alert alert-warning">
    <strong><strong><?= $model->getAttributeLabel('google_analytics_js'); ?></strong> - не изменяйте если вы не уверены в своих действиях. Данных которых здесь нету, буду добавлены автоматически.
</div>
<?= $form->field($model, 'google_site_verification')->hint('Example: ABcD1aBcDeABcjeaB33eABQDep8cDe-ABcD2aBo56'); ?>

<?= $form->field($model, 'google_tag_manager')
    ->hint('Example: GTM-ABC1234')
    ->textInput(['maxlength' => 11]); ?>
<?= $form->field($model, 'google_tag_ecommerce')->hint('динамический ремаркетинг: <strong>conversionintent, conversion, offerdetail</strong>')->checkbox(); ?>

<?= $form->field($model, 'google_analytics_id')
    ->hint('Example: UA-1234567-00')
    ->textInput(['maxlength' => 15]); ?>

<?= $form->field($model, 'google_analytics_js')
    ->textarea(['rows' => 6])
    ->hint('<code>{code}</code> - UA-1234567-00'); ?>

