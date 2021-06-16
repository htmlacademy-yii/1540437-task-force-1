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
        $this->alterColumn('tasks', 'status', "ENUM('NEW', 'CANCELED', 'INPROGRESS', 'COMPLETE', 'FAIL', 'DRAFT')");
        $this->alterColumn('tasks', 'category_id', $this->integer()->unsigned()->null());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->alterColumn('tasks', 'status', "ENUM('NEW', 'CANCELED', 'INPROGRESS', 'COMPLETE', 'FAIL')");
        $this->alterColumn('tasks', 'category_id', $this->integer()->unsigned()->notNull());
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
