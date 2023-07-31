<?php

use yii\db\Migration;

/**
 * Class m230726_164140_create_price
 */
class m230726_164140_create_price extends Migration
{
    public function up()
    {
        $this->createTable('price', [
            'id' => $this->primaryKey(11)->unsigned()->notNull(),
            'tonnage_id' => $this->integer(11)->unsigned()->notNull(),
            'month_id' => $this->integer(11)->unsigned()->notNull(),
            'raw_type_id' => $this->integer(11)->unsigned()->notNull(),
            'value' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP()'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP()")->append('ON UPDATE CURRENT_TIMESTAMP()'),
        ]);

        //unique
        $this->createIndex(
            'UNIQUE',
            'price',
            'tonnage_id, month_id, raw_type_id',
            true,
        );


        $this->addForeignKey(
            'fk-price-tonnage_id',
            'price',
            'tonnage_id',
            'tonnage',
            'id',
            'CASCADE',
            'NO ACTION'
        );


        $this->addForeignKey(
            'fk-price-month_id',
            'price',
            'month_id',
            'month',
            'id',
            'CASCADE',
            'NO ACTION'

        );

        $this->addForeignKey(
            'fk-price-raw_type_id',
            'price',
            'raw_type_id',
            'raw_type',
            'id',
            'CASCADE',
            'NO ACTION'
        );

        $this->batchInsert('price', ['tonnage_id', 'month_id', 'raw_type_id', 'value'], $this->getPriceData());
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('price');
    }

    private function getPriceData(): array
    {
        return [
            [1, 1, 1, 125],
            [2, 1, 1, 145],
            [3, 1, 1, 136],
            [4, 1, 1, 138],
            [1, 2, 1, 121],
            [2, 2, 1, 118],
            [3, 2, 1, 137],
            [4, 2, 1, 142],
            [1, 3, 1, 137],
            [2, 3, 1, 119],
            [3, 3, 1, 141],
            [4, 3, 1, 117],
            [1, 4, 1, 126],
            [2, 4, 1, 121],
            [3, 4, 1, 137],
            [4, 4, 1, 124],
            [1, 5, 1, 124],
            [2, 5, 1, 122],
            [3, 5, 1, 131],
            [4, 5, 1, 147],
            [1, 6, 1, 128],
            [2, 6, 1, 147],
            [3, 6, 1, 143,],
            [4, 6, 1, 112,],
            [1, 1, 2, 121,],
            [2, 1, 2, 118,],
            [3, 1, 2, 137,],
            [4, 1, 2, 142,],
            [1, 2, 2, 137,],
            [2, 2, 2, 121,],
            [3, 2, 2, 124,],
            [4, 2, 2, 131,],
            [1, 3, 2, 124,],
            [2, 3, 2, 145,],
            [3, 3, 2, 136,],
            [4, 3, 2, 138,],
            [1, 4, 2, 137,],
            [2, 4, 2, 147,],
            [3, 4, 2, 143,],
            [4, 4, 2, 112,],
            [1, 5, 2, 122,],
            [2, 5, 2, 143,],
            [3, 5, 2, 112,],
            [4, 5, 2, 117,],
            [1, 6, 2, 125,],
            [2, 6, 2, 145,],
            [3, 6, 2, 136,],
            [4, 6, 2, 138,],
            [1, 1, 3, 137,],
            [2, 1, 3, 147,],
            [3, 1, 3, 112,],
            [4, 1, 3, 122,],
            [1, 2, 3, 125,],
            [2, 2, 3, 145,],
            [3, 2, 3, 136,],
            [4, 2, 3, 138,],
            [1, 3, 3, 124,],
            [2, 3, 3, 145,],
            [3, 3, 3, 136,],
            [4, 3, 3, 138,],
            [1, 4, 3, 122,],
            [2, 4, 3, 143,],
            [3, 4, 3, 112,],
            [4, 4, 3, 117,],
            [1, 5, 3, 137,],
            [2, 5, 3, 119,],
            [3, 5, 3, 141,],
            [4, 5, 3, 117,],
            [1, 6, 3, 121,],
            [2, 6, 3, 118,],
            [3, 6, 3, 137,],
            [4, 6, 3, 142,],
        ];
    }
}
