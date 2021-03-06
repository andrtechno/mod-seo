<?php

namespace panix\mod\seo\plugins;

use Yii;
use yii\helpers\Url;

/**
 * Class SeoPlugin
 * @package panix\mod\seo\plugins
 */
class SeoPlugin
{
    /**
     * Set page suffix
     * Handler for yii\base\Application::beforeRequest
     */
    public static function clearUrl()
    {
        $redirectList = ['/index.php', '/site', '/site/index'];
        $request = Yii::$app->request->url;
        if (in_array($request, $redirectList)) {
            return Yii::$app->response->redirect(Url::to('/'), 301);
        }
    }

    /**
     * Set page suffix
     * Handler for yii\web\View::beginPage
     */
    public static function title()
    {
        $title = Yii::$app->settings->get('app', 'sitename');
        $seo_config = Yii::$app->settings->get('seo');

        if (Yii::$app instanceof \yii\web\Application === true) {
            if (Yii::$app->request->get('page') !== null) {
                Yii::$app->view->title .= Yii::t(
                    'seo/default',
                    'TITLE_PAGE',
                    ['page' => (int)Yii::$app->request->get('page')]
                );
            }

            if (!empty(Yii::$app->view->title)) {
                Yii::$app->view->title .= ' ' . $seo_config->title_prefix . ' ' . $title;
            } else {
                Yii::$app->view->title .= $title;
            }


        }
    }

}