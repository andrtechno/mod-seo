<?php

namespace panix\mod\seo;

use panix\engine\web\AssetBundle;


class SeoAsset extends AssetBundle {

    public $sourcePath = __DIR__.'/assets';

    public $js = [
        'js/seo.js',
    ];

    public $depends = [
        'yii\jui\JuiAsset',
    ];

}
