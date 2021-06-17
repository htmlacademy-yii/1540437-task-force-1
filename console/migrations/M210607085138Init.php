<?php

namespace console\migrations;

use yii\db\Migration;

/**
 * Class M210607085138Init
 */
class M210607085138Init extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $basePath = \Yii::$app->basePath . "/..";
        $schemaSql = \file_get_contents($basePath . '/data/db/schema.sql');
        $categoriesSql = \file_get_contents($basePath . '/data/sql/categories.sql');
        $citiesSql = \file_get_contents($basePath .  '/data/sql/cities.sql');

        $this->execute($schemaSql . $categoriesSql . $citiesSql);
        // $this->execute($categoriesSql);
        // $this->execute($citiesSql);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "M210607085138Init cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M210607085138Init cannot be reverted.\n";

        return false;
    }
    */
}
