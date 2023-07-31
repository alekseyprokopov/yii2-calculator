<?php

use yii\db\Migration;

/**
 * Class m230726_164112_create_tonnage
 */
class m230726_164112_create_tonnage extends Migration
{
    public function up()
    {
        $this->createTable('tonnage', [
            'id' => $this->primaryKey(11)->unsigned()->notNull(),
            'value' => $this->tinyInteger()->unsigned()->notNull()->unique(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP()'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP()")->append('ON UPDATE CURRENT_TIMESTAMP()'),
        ]);

        $this->batchInsert('tonnage', ['value'], $this->getTonnagesData());
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('tonnage');
    }

    private function getTonnagesData(): array
    {
        return [[25], [50], [75], [100]];
    }

}
