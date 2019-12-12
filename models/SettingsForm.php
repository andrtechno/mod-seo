<?php

namespace panix\mod\seo\models;

use Yii;
use panix\engine\SettingsModel;
use panix\engine\CMS;

class SettingsForm extends SettingsModel
{
    public static $category = 'seo';
    protected $module = 'seo';

    public $path_robots;

    public $googleanalytics_id;
    public $googleanalytics_js;
    public $google_tag_manager;
    public $google_tag_manager_js;
    public $canonical;
    public $google_site_verification;
    public $yandex_verification;
    public $title_prefix;
    public $robots;

    public $nested_url;
    public $favicon_size;

    public function init()
    {
        if (file_exists(Yii::getAlias('@app/web') . DIRECTORY_SEPARATOR . 'robots.txt')) {
            $this->path_robots = Yii::getAlias('@app/web') . DIRECTORY_SEPARATOR . 'robots.txt';
        }
        if ($this->path_robots) {
            $this->robots = CMS::textReplace(file_get_contents($this->path_robots, false), [], true);
        }
        parent::init();
    }

    public function save()
    {
        $request = Yii::$app->request;


        /*if ($request->post('robots_reset')) {
            if ($request->post('robots_reset')) {
                $robots_h = fopen($this->path_robots, "wb");
                fwrite($robots_h, $this->defaultRobots());
                fclose($robots_h);
            }
        }*/

        $robots_h = fopen($this->path_robots, "wb");
        fwrite($robots_h, CMS::textReplace($this->robots));
        fclose($robots_h);
       // $this->favicon_size = implode(',', $this->favicon_size);

        return parent::save();
    }


    public static function defaultSettings()
    {
        return [
            'title_prefix' => '/',
            'googleanalytics_id' => null,
            'google_tag_manager' => null,
            'nested_url' => false,
            'canonical' => true,
            'google_site_verification' => '',
            'yandex_verification' => '',
            'googleanalytics_js' => "window.dataLayer = window.dataLayer || [];
function gtag() {
    dataLayer.push(arguments);
}
gtag('js', new Date());
gtag('config', '{code}');
",
            'google_tag_manager_js' => "(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','{code}');"
        ];
    }

    public function rules()
    {
        return [
            ['title_prefix', 'required'],
            ['favicon_size', 'each', 'rule' => ['integer']],
           // ['favicon_size', 'in', 'range' => [16, 32, 57, 60, 72, 76, 96, 114, 120, 144, 152, 180]],
            [['canonical', 'nested_url'], 'boolean'],
            ['google_tag_manager', 'match', 'pattern' => '/GTM-[A-Z0-9]{7}/i'],
            ['google_tag_manager', 'string', 'max' => 11, 'min' => 11],
            ['googleanalytics_id', 'string', 'max' => 13, 'min' => 13],
            ['googleanalytics_id', 'match', 'pattern' => '/UA-[0-9]{7}-[0-9]{1,}/i'],
            [['title_prefix', 'robots', 'google_site_verification', 'yandex_verification', 'google_tag_manager', 'googleanalytics_id', 'google_tag_manager_js', 'googleanalytics_js'], 'string']
        ];
    }

    protected function defaultRobots()
    {
        return 'User-Agent: *
Disallow: /placeholder
Disallow: /admin/auth
Disallow: /assets/
Disallow: /themes/
Disallow: /cart/*

Host: ' . Yii::$app->request->hostInfo . '

' . ((Yii::$app->hasModule('sitemap')) ? 'Sitemap: ' . Yii::$app->request->hostInfo . '/sitemap.xml' : '') . '';
    }
}
