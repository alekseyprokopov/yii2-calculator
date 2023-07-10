<?php

use yii\db\Migration;

/**
 * Class m230708_211151_prices
 */
class m230708_211151_prices extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('prices', [
            'id' => $this->primaryKey(11)->unsigned()->notNull(),
            'tonnage_id' => $this->integer(11)->unsigned()->notNull(),
            'month_id' => $this->integer(11)->unsigned()->notNull(),
            'raw_type_id' => $this->integer(11)->unsigned()->notNull(),
            'price' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP()'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP()")->append('ON UPDATE CURRENT_TIMESTAMP()'),
        ]);

        //unique
        $this->createIndex(
            'UNIQUE',
            'prices',
            'tonnage_id, month_id, raw_type_id',
            true,
        );

        //fk-tonnage
        $this->createIndex(
            'idx-prices-tonnage_id',
            'prices',
            'tonnage_id'
        );

        $this->addForeignKey(
            'fk-prices-tonnage_id',
            'prices',
            'tonnage_id',
            'tonnages',
            'id',
            'CASCADE',
            'NO ACTION'
        );

        //fk-month
        $this->createIndex(
            'idx-prices-month_id',
            'prices',
            'month_id'
        );

        $this->addForeignKey(
            'fk-prices-month_id',
            'prices',
            'month_id',
            'months',
            'id',
            'CASCADE',
            'NO ACTION'

        );

        //fk-raw_type
        $this->createIndex(
            'idx-prices-raw_type_id',
            'prices',
            'raw_type_id'
        );

        $this->addForeignKey(
            'fk-prices-raw_type_id',
            'prices',
            'raw_type_id',
            'raw_types',
            'id',
            'CASCADE',
            'NO ACTION'
        );

        $pricesRows = Yii::$app->params['sqlMigrationData']['prices'];
        $this->batchInsert('prices', ['tonnage_id', 'month_id', 'raw_type_id', 'price'], $pricesRows);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('prices');
    }

}
