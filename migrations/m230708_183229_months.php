<?php

use yii\db\Migration;

/**
 * Class m230708_183229_months
 */
class m230708_183229_months extends Migration
{
    /**
     * {@inheritdoc}
     */

    public function up()
    {
        $monthRows = Yii::$app->params['sqlMigrationData']['months'];

        $this->createTable('months', [
            'id' => $this->primaryKey(11)->unsigned()->notNull(),
            'name' => $this->string(10)->unsigned()->notNull()->unique(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP()'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP()")->append('ON UPDATE CURRENT_TIMESTAMP()'),
        ]);

        $this->batchInsert('months', ['name'], $monthRows);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('months');
    }


}
