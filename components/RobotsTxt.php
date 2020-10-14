<?php

namespace panix\mod\seo\components;

use panix\engine\CMS;
use Yii;
use yii\helpers\Url;

/**
 * Class RobotsTxt
 * @package panix\mod\seo
 */
class RobotsTxt extends \yii\base\Component
{
    /** @var sting */
    public $host = '';
    /** @var string */
    public $sitemap = '';
    /** @var array */
    public $userAgent = [];
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if (empty($this->host)) {
            if (Yii::$app->request->IsSecureConnection) {
                $this->host = Yii::$app->request->hostInfo;
            } else {
                $this->host = Yii::$app->request->serverName;
            }
        }
    }
    /**
     * render robots.txt
     *
     * @return string
     */
    public function render()
    {
        $result = "";
        $params = [];
        $params['Host'] = $this->host;
        $params['Sitemap'] = $this->sitemap;
        foreach ($this->userAgent as $userAgent => $value) {
            $result .= "User-agent: $userAgent\n";
            foreach ($value as $permission => $urls) {
                foreach ($urls as $url) {
                    $url = Url::to($url);
                    $result .= "$permission: $url\n";
                }
            }
            $result .= "\n";
        }

        foreach (array_filter($params) as $key => $value) {
            $result .= "$key: $value\n";
        }

        return $result;

    }
}
