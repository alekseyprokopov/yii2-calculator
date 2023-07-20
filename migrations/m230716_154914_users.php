<?php

use yii\db\Migration;

/**
 * Class m230716_154914_users
 */
class m230716_154914_users extends Migration
{
    /**
     * {@inheritdoc}
     */


    public function up()
    {

        $this->createTable('users', [
            'id' => $this->primaryKey(11)->unsigned()->notNull(),
            'name' => $this->string(256)->unsigned()->notNull(),
            'email' => $this->string(256)->unsigned()->notNull()->unique(),
            'password' => $this->string(256)->unsigned()->notNull(),
            'auth_key' => $this->string(256)->null(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP()'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP()")->append('ON UPDATE CURRENT_TIMESTAMP()'),
        ]);

//        $this->batchInsert('raw_types', ['name'], $this->getRawTypesData());

    }

    public function down()
    {
        $this->dropTable('users');

        return false;
    }
}

//yii migrate --migrationPath=@yii/rbac/migrations
