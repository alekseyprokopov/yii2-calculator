<?php

use yii\db\Migration;

/**
 * Class m230708_183340_raw_types
 */
class m230708_183340_raw_types extends Migration
{
    /**
     * {@inheritdoc}
     */

    public function up()
    {
        $this->createTable('raw_types', [
            'id' => $this->primaryKey(11)->unsigned()->notNull(),
            'name' => $this->string(10)->unsigned()->notNull()->unique(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP()'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP()")->append('ON UPDATE CURRENT_TIMESTAMP()'),
        ]);

        $rawTypeRows = Yii::$app->params['sqlMigrationData']['raw_types'];
        $this->batchInsert('raw_types', ['name'], $rawTypeRows);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('raw_types');
    }

}
