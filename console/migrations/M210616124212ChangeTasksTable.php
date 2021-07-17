<?php

namespace console\migrations;

use yii\db\Migration;

/**
 * Class M210616124212ChangeTasksTable
 */
class M210616124212ChangeTasksTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->alterColumn('tasks', 'category_id', $this->integer()->unsigned()->null());
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "M210616124212ChangeTasksTable cannot be reverted.\n";
        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "M210616124212ChangeTasksTable cannot be reverted.\n";

        return false;
    }
    */
}
