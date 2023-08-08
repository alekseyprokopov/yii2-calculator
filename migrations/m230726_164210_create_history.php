<?php

use yii\db\Migration;

/**
 * Class m230726_164210_create_history
 */
class m230726_164210_create_history extends Migration
{
    public function up()
    {
        $this->createTable('history', [
            'id' => $this->primaryKey(11)->unsigned()->notNull(),
            'username' => $this->string(256)->unsigned()->notNull(),
            'email' => $this->string(256)->unsigned()->notNull(),
            'tonnage' => $this->tinyInteger()->unsigned()->notNull(),
            'month' => $this->string(10)->unsigned()->notNull(),
            'raw_type' => $this->string(10)->unsigned()->notNull(),
            'price' => $this->integer()->unsigned()->notNull(),
            'table_data' => $this->string(1000)->unsigned()->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP()'),
        ]);

    }

    public function down()
    {
        $this->dropTable('history');
    }
}
