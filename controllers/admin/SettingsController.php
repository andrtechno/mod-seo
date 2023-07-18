<?php

namespace panix\mod\seo\controllers\admin;

use Yii;
use panix\engine\Html;
use panix\mod\seo\models\SettingsForm;
use panix\engine\controllers\AdminController;
use yii\web\UploadedFile;

/**
 * Class SettingsController
 * @package panix\mod\seo\controllers\admin
 */
class SettingsController extends AdminController
{
    public function actions()
    {
        return [
            'delete-file' => [
                'class' => 'panix\engine\actions\DeleteFileAction',
                'modelClass' => Brand::class,
            ],
        ];
    }
    public function actionIndex()
    {
        $this->pageName = Yii::t('app/default', 'SETTINGS');

        $this->view->params['breadcrumbs'][] = [
            'label' => $this->module->info['label'],
            'url' => $this->module->info['url'],
        ];

        $this->view->params['breadcrumbs'][] = $this->pageName;
        $model = new SettingsForm();
        $model->favicon_size = explode(',', $model->favicon_size);
        $oldOgImage = $model->og_image;

        if ($model->load(Yii::$app->request->post())) {
            $model->og_image = UploadedFile::getInstance($model, 'og_image');

            if ($model->validate()) {
                if ($model->og_image) {
                    $fileName = 'og-image.' . $model->og_image->extension;
                    $img = Yii::$app->img;
                    $img->load($model->og_image->tempName);
                    $img->resize(800, 800);
                    $img->save(Yii::getAlias("@uploads/{$fileName}"));
                    $model->og_image = $fileName;
                } else {
                    $model->og_image = $oldOgImage;
                }

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
