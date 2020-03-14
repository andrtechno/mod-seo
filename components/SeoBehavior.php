<?php

namespace panix\mod\seo\components;


use Yii;
use yii\db\ActiveRecord;
use panix\mod\seo\models\SeoUrl;
use yii\helpers\Url;
use yii\base\Behavior;
use panix\engine\CMS;

/**
 * Class SeoBehavior
 * @package panix\mod\seo\components
 */
class SeoBehavior extends Behavior
{

    /**
     * @var string model primary key attribute
     */
    public $pk = 'id';

    /**
     * @var string attribute name to present comment owner in admin panel. e.g: name - references to Page->name
     */
    public $url;

    /**
     * @var array Old url
     */
    private $afterUrl;


    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_AFTER_FIND => function () {
                if (method_exists($this->owner, 'getUrl')) {
                    $this->afterUrl = $this->owner->getUrl();
                }
            },
        ];
    }

    /**
     * @return bool
     */
    public function afterSave()
    {

        if (!Yii::$app instanceof \yii\console\Application) {
            /** @var ActiveRecord $owner */
            $owner = $this->owner;
            $handler_class = '\\'.get_class($owner);
            $handler_hash = CMS::hash($handler_class);
            if ($owner->isNewRecord) {
                $seo = new SeoUrl;
            } else {
                $url = (Url::to($this->afterUrl) == Url::to($owner->getUrl())) ? $owner->getUrl() : $this->afterUrl;
                $seo = SeoUrl::find()->where([
                    'owner_id' => $owner->primaryKey,
                    'handler_hash' => $handler_hash
                ])->one();
                //$seo = SeoUrl::find()->where(['url' => Url::to($url)])->one();
                if (!$seo) {
                    $seo = new SeoUrl;
                }
            }
            $seo->load(['SeoUrl' => Yii::$app->request->post('SeoUrl')]);
            $seo->url = Yii::$app->urlManager->createUrl($owner->getUrl());
            $seo->meta_robots = null;
            $seo->owner_id = $owner->primaryKey;
            $seo->handler_class = $handler_class;
            $seo->handler_hash = $handler_hash;
            $seo->save();
            return true;
        }
    }

    /**
     * @return bool
     */
    public function afterDelete()
    {
        /** @var ActiveRecord $owner */
        $owner = $this->owner;
        try{
            SeoUrl::deleteAll([
                'owner_id' => $owner->primaryKey,
                'handler_hash' => $owner->getHash()
            ]);

            //  SeoUrl::deleteAll(['url' => Yii::$app->urlManager->createUrl($this->url)]);
            return true;
        }catch (Exception $e){

        }

    }

}
