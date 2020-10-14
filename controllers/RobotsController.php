<?php

namespace panix\mod\seo\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;


class RobotsController extends Controller
{

    public function behaviors2()
    {
        return [
            'pageCache' => [
                'class' => 'yii\filters\PageCache',
                'only' => ['index'],
                'duration' => 86400*7,
               // 'variations' => [Yii::$app->request->get('id')],
            ],
        ];
    }


    public function actionIndex()
    {

        $robotsTxt = empty(Yii::$app->components['robotsTxt']) ? new RobotsTxt() : Yii::$app->robotsTxt;
        $robotsTxt->sitemap = Yii::$app->urlManager->createAbsoluteUrl(
            empty($robotsTxt->sitemap) ? [$this->module->id.'/'.$this->id.'/index'] : $robotsTxt->sitemap
        );
        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'text/plain');
        return $robotsTxt->render();
    }

}
