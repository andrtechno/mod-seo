<?php

namespace panix\mod\seo\components;

use Yii;
use yii\base\Exception;
use yii\db\ActiveRecord;
use panix\mod\seo\models\SeoMain;
use panix\mod\seo\models\SeoUrl;
use yii\helpers\Url;
use yii\base\Behavior;

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

    public function attach($owner)
    {
        if (!$this->url)
            throw new Exception('err');

        parent::attach($owner);
    }

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_BEFORE_UPDATE => 'beforeSave',
            ActiveRecord::EVENT_BEFORE_INSERT => 'beforeSave',
        ];
    }
    public $beforeUrl;
    public function beforeSave()
    {
        $owner = $this->owner;
        $this->beforeUrl = $owner->getUrl();
        //print_r($this->url);
        //print_r($owner->getUrl());
    }
    public function afterSave()
    {

        if (!Yii::$app instanceof \yii\console\Application) {
            $owner = $this->owner;
            if ($owner->isNewRecord) {
                $seo = new SeoUrl;
            } else {
                $seo = SeoUrl::find()->where(['url' => Yii::$app->urlManager->createUrl($owner->getUrl())])->one();
                if (!$seo) {
                    $seo = new SeoUrl;
                }
            }


            //var_dump($owner->getUrl());

            $s = $this->beforeUrl;
            print_r($s);
            print_r($owner->getUrl());
            die;



            $seo->load(Yii::$app->request->post('SeoUrl'));
            $old = $seo->oldAttributes;


            $seo->url = Yii::$app->urlManager->createUrl($owner->getUrl());
            // $seo->meta_robots = null;
            $seo->save(false);

            return true;
        }
    }

    /**
     * @return mixed
     */
    public function afterDelete()
    {
        SeoUrl::deleteAll(['url' => Yii::$app->urlManager->createUrl($this->url)]);
        return true;
    }

}
