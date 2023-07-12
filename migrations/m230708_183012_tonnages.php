<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m230708_183012_tonnages
 */
class m230708_183012_tonnages extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('tonnages', [
            'id' => $this->primaryKey(11)->unsigned()->notNull(),
            'value' => $this->tinyInteger()->unsigned()->notNull()->unique(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP()'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP()")->append('ON UPDATE CURRENT_TIMESTAMP()'),
        ]);

        $tonnageRows = Yii::$app->params['sqlMigrationData']['tonnages'];
        $this->batchInsert('tonnages', ['value'], $tonnageRows);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('tonnages');
    }

}
