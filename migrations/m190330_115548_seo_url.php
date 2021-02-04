<?php

/**
 * Generation migrate by PIXELION CMS
 *
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 * @link http://pixelion.com.ua PIXELION CMS
 *
 * Class m190330_115548_seo_url
 */

use panix\engine\db\Migration;
use panix\mod\seo\models\SeoUrl;

class m190330_115548_seo_url extends Migration
{

    public $settingsForm = 'panix\mod\seo\models\SettingsForm';

    public function up()
    {
        $this->createTable(SeoUrl::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'owner_id' => $this->integer()->unsigned()->null(),
            'handler_hash' => $this->string(8)->null(),
            'handler_class' => $this->string(255)->null(),
            'url' => $this->string(255)->notNull(),
            'title' => $this->string(150)->null(),
            'domain' => $this->tinyInteger(1)->defaultValue(1),
            'description' => $this->string(255)->null(),
            'meta_robots' => $this->string(16)->null(),
            'h1' => $this->string(255)->null(),
            'text' => $this->text()->null()
        ], $this->tableOptions);

        $this->createIndex('url', SeoUrl::tableName(), 'url');
        $this->createIndex('owner_id', SeoUrl::tableName(), 'owner_id');
        $this->createIndex('handler_hash', SeoUrl::tableName(), 'handler_hash');
        $this->loadSettings();
    }

    public function down()
    {
        $this->dropTable(SeoUrl::tableName());
    }

}
