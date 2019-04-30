<?php

namespace panix\mod\seo\models;

use Yii;
use panix\mod\seo\models\SeoParams;

class SeoUrl extends \panix\engine\db\ActiveRecord
{


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
            ['meta_robots', 'default', 'value' => null],
            ['meta_robots', 'robotsValidator'],
        ];
    }

    public function robotsValidator($attribute)
    {

        if ($this->{$attribute}) {
            if (count($this->$attribute) <= 2) {
                $this->$attribute = implode(',', $this->$attribute);
            } else {
                $this->addError($attribute, 'Максимальное выбранное значеное 2 шт.');
            }
        }
    }

    public function getParams()
    {
        return $this->hasMany(SeoParams::class, ['url_id' => 'id']);
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
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
