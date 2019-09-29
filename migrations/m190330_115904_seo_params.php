<?php
namespace panix\mod\seo\migrations;
/**
 * Generation migrate by PIXELION CMS
 *
 * @author PIXELION CMS development team <dev@pixelion.com.ua>
 * @link http://pixelion.com.ua PIXELION CMS
 *
 * Class m190330_115904_seo_params
 */

use panix\engine\db\Migration;
use panix\mod\seo\models\SeoParams;

class m190330_115904_seo_params extends Migration {

    // Use up()/down() to run migration code without a transaction.
    public function up() {
        $this->createTable(SeoParams::tableName(), [
            'id' => $this->primaryKey()->unsigned(),
            'url_id' => $this->integer()->unsigned(),
            'param' => $this->string(255)->null(),
            'obj' => $this->string(255)->null(),
            'modelClass' => $this->string(255)->null(),
        ], $this->tableOptions);
        $this->createIndex('url_id', SeoParams::tableName(), 'url_id');
    }

    public function down() {
        $this->dropTable(SeoParams::tableName());
    }

}
