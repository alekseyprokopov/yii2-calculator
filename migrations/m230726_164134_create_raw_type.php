<?php

use yii\db\Migration;

/**
 * Class m230726_164134_create_raw_type
 */
class m230726_164134_create_raw_type extends Migration
{
    public function up()
    {
        $this->createTable('raw_type', [
            'id' => $this->primaryKey(11)->unsigned()->notNull(),
            'name' => $this->string(10)->unsigned()->notNull()->unique(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP()'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP()")->append('ON UPDATE CURRENT_TIMESTAMP()'),
        ]);

        $this->batchInsert('raw_type', ['name'], $this->getRawTypesData());
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('raw_type');
    }

    private function getRawTypesData(): array
    {
        return [['шрот'], ['жмых'], ['соя']];
    }
}
