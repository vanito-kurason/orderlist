<?php

namespace vanitokurason\orderlist;

use yii\db\Migration;

/**
 * Class m230122_214904_add_indexes
 */
class m230122_214904_add_indexes extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createIndex('user_index', 'orders', 'user_id');
        $this->createIndex('filter_index', 'orders', ['service_id', 'status', 'mode']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230122_214904_add_indexes cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230122_214904_add_indexes cannot be reverted.\n";

        return false;
    }
    */
}
