<?php

namespace console\migrations;

use yii\db\Migration;

/**
 * Class M210617075725AddPublishDateToTaskTable
 */
class M210617075725AddPublishDateToTaskTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('tasks', 'published_at', $this->timestamp()->null());
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('tasks', 'published_at');
        return true;
    }
}
