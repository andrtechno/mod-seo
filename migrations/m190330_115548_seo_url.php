<?php

namespace panix\mod\seo\migrations;

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
use panix\mod\seo\models\SettingsForm;
use panix\engine\components\Settings;

class m190330_115548_seo_url extends Migration
{

    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable(SeoUrl::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'url' => $this->string(255)->notNull(),
            'title' => $this->string(150)->null(),
            'domain'=>$this->tinyInteger(1)->defaultValue(1),
            'description' => $this->string(255)->null(),
            'meta_robots' => $this->string(16)->null(),
            'h1' => $this->string(255)->null(),
            'text' => $this->text()->null()
        ], $this->tableOptions);

        $this->createIndex('url', SeoUrl::tableName(), 'url');

        $settings = [];
        foreach (SettingsForm::defaultSettings() as $key => $value) {
            $settings[] = [SettingsForm::$category, $key, $value];
        }

        $this->batchInsert(Settings::$tableName, ['category', 'param', 'value'], $settings);


    }

    public function down()
    {
        echo "m190330_115548_seo_url cannot be reverted.\n";
        $this->dropTable(SeoUrl::tableName());
        return false;
    }

}
