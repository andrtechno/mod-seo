<?php

namespace panix\mod\seo\models;

use panix\engine\db\ActiveRecord;

/**
 * Class Utm
 * @property string $utm_source
 * @property string $utm_content
 * @property string $utm_campaign
 * @property string $utm_term
 * @property string $utm_medium
 * @property int $created_at
 *
 * @package panix\mod\seo\models
 */
class Utm extends ActiveRecord
{

    const MODULE_ID = 'seo';

    public static function tableName()
    {
        return '{{%utm}}';
    }

}
