<?php

namespace panix\mod\seo;

use Yii;
use panix\engine\WebModule;

class Module extends WebModule
{

    public $icon = 'seo-monitor';


    public function getInfo()
    {
        return [
            'label' => Yii::t('seo/default', 'MODULE_NAME'),
            'author' => $this->author,
            'version' => '1.0',
            'icon' => $this->icon,
            'description' => Yii::t('seo/default', 'MODULE_DESC'),
            'url' => ['/admin/seo'],
        ];
    }

    public function getAdminMenu()
    {
        return [
            'system' => [
                'items' => [
                    [
                        'label' => Yii::t('seo/default', 'MODULE_NAME'),
                        'url' => ['/admin/seo'],
                        'icon' => $this->icon,
                        'visible' => Yii::$app->user->can('/seo/admin/default/index') || Yii::$app->user->can('/seo/admin/default/*')
                    ],
                ],
            ]
        ];
    }

}
