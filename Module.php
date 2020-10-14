<?php

namespace panix\mod\seo;

use Yii;
use panix\engine\WebModule;
use yii\base\BootstrapInterface;

class Module extends WebModule implements BootstrapInterface
{

    public $icon = 'seo-monitor';

    public function bootstrap($app)
    {
        $app->urlManager->addRules(
            [
                ['pattern' => 'robots1', 'route' => 'seo/robots/index', 'suffix' => '.txt'],
            ],
            true
        );


        $app->setComponents([
            'robotsTxt' => [
                'class' => 'panix\mod\seo\components\RobotsTxt',
                'userAgent' => [
                    // Disallow url for all bots
                    '*' => [
                        'Disallow' => [
                            ['/admin'],
                            '/assets'
                        ],
                        'Allow' => [
                            ['/api/doc/index'],
                        ],
                    ],
                    // Block a specific image from Google Images
                    'Googlebot-Image' => [
                        'Disallow' => [
                            // All images on your site from Google Images
                            '/',
                            // Files of a specific file type (for example, .gif)
                            '/*.gif$',
                        ],
                    ],
                ],
            ],
        ]);


    }

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
