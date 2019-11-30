<?php

namespace panix\mod\seo\models;

use Yii;
use panix\mod\seo\models\SeoParams;
use panix\engine\db\ActiveRecord;

/**
 * Class SeoUrl
 *
 * @property integer $id
 * @property integer $owner_id
 * @property string $handler_hash
 * @property string $handler_class
 * @property string $url
 * @property string $title
 * @property string $meta_robots
 * @property string $h1
 * @property string $text
 * @property string $description
 *
 * @package panix\mod\seo\models
 */
class SeoUrl extends ActiveRecord
{

    const MODULE_ID = 'seo';

    /**
     * @return string the associated database table name
     */
    public static function tableName()
    {
        return '{{%seo_url}}';
    }

    public function defaultScope()
    {
        return array(
            'order' => 'id DESC'
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['url', 'required'],
            // ['url', 'UniqueAttributesValidator', 'with' => 'url'],
            [['title', 'description', 'text', 'h1'], 'string'],
            ['title', 'string', 'max' => 150],
            ['url', 'trim'],
            [['meta_robots', 'title', 'description', 'text', 'h1'], 'default'],
            ['meta_robots', 'robotsValidator'],
        ];
    }

    public function robotsValidator($attribute)
    {
        $list = $this->{$attribute};
        if (is_array($list)) {
            if (count($list) <= 2) {
                $this->{$attribute} = implode(',', $list);
            } else {
                $this->addError($attribute, self::t('ERROR_ROBOTS'));
            }
        }
    }

    public function getParams()
    {
        return $this->hasMany(SeoParams::class, ['url_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        //$this->domain = static::getDomainId();
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        if (!$this->getIsNewRecord()) {
            if ($this->meta_robots) {
                $this->meta_robots = explode(',', $this->meta_robots);
            }
        }
        parent::afterFind();
    }

    public static function getDomainId()
    {
        return array_search(str_replace('www.', '', Yii::$app->request->serverName), Yii::$app->params['domains']);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels2()
    {
        return [
            'id' => 'ID',
            'url' => Yii::t('seo/default', 'URL'),
            'text' => Yii::t('seo/default', 'TEXT'),
            'description' => Yii::t('seo/default', 'DESCRIPTION'),
            'title' => Yii::t('seo/default', 'TITLE'),
        ];
    }


}
