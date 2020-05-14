<?php

namespace panix\mod\seo\controllers\admin;

use Yii;
use panix\engine\Html;
use panix\mod\seo\models\SettingsForm;
use panix\engine\controllers\AdminController;

/**
 * Class SettingsController
 * @package panix\mod\seo\controllers\admin
 */
class SettingsController extends AdminController
{

    public function actionIndex()
    {
        $this->pageName = Yii::t('app/default', 'SETTINGS');

        $this->breadcrumbs[] = [
            'label' => $this->module->info['label'],
            'url' => $this->module->info['url'],
        ];

        $this->breadcrumbs[] = $this->pageName;
        $model = new SettingsForm();
        $model->favicon_size = explode(',', $model->favicon_size);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if (!empty($model->favicon_size))
                    $model->favicon_size = implode(",", $model->favicon_size);
                $model->save();

                Yii::$app->session->setFlash("success", Yii::t('app/default', 'SUCCESS_UPDATE'));
                return $this->refresh();
            }
        }
        return $this->render('index', ['model' => $model]);
    }

    public function getAddonsMenu()
    {
        return [
            [
                'label' => Yii::t('seo/default', 'REDIRECTS'),
                'url' => ['/admin/seo/redirects'],
                'icon' => 'refresh',

            ],
        ];
    }

}
