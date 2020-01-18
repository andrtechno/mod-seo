<?php
use panix\engine\CMS;

/**
 * @var $form \panix\engine\bootstrap\ActiveForm
 * @var $model \panix\mod\seo\models\SettingsForm
 */

if (CMS::isChmod($model->path_robots, 0666))
    echo \panix\engine\bootstrap\Alert::widget([
        'options' => [
            'class' => 'alert-warning',
        ],
        'body' => Yii::t('app/default', 'CHMOD_ERROR', ['dir' => $model->path_robots, 'chmod' => 666]),
    ]);
?>
<?= $form->field($model, 'robots')
    ->textarea(['rows' => 10, 'style' => 'resize:none;'])->hint('
<div><code>{domain}</code> - ' . Yii::$app->request->serverName . '</div>
<div><code>{scheme}</code> - https:// or http://</div>'); ?>

