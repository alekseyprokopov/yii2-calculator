<?php

use yii\db\Migration;

/**
 * Class m230726_164122_create_month
 */
class m230726_164122_create_month extends Migration
{
    public function up()
    {
        $this->createTable('month', [
            'id' => $this->primaryKey(11)->unsigned()->notNull(),
            'name' => $this->string(10)->unsigned()->notNull()->unique(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP()'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP()")->append('ON UPDATE CURRENT_TIMESTAMP()'),
        ]);

        $this->batchInsert('month', ['name'], $this->getMonthsData());
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('month');
    }

    private function getMonthsData()
    {
        return [
            ['январь'], ['февраль'], ['август'], ['сентябрь'], ['октябрь'], ['ноябрь']
        ];
    }
}
