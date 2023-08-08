<?php

use yii\db\Migration;

/**
 * Class m230726_164147_create_user
 */
class m230726_164147_create_user extends Migration
{
    public function up()
    {

        $this->createTable('user', [
            'id' => $this->primaryKey(11)->unsigned()->notNull(),
            'username' => $this->string(256)->unsigned()->notNull(),
            'email' => $this->string(256)->unsigned()->notNull()->unique(),
            'password_hash' => $this->string(256)->unsigned()->notNull(),
            'status' => $this->smallInteger()->unsigned()->notNull()->defaultValue(10),
            'auth_key' => $this->string(256)->null(),
            'created_at' => $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP()'),
            'updated_at' => $this->timestamp()->notNull()->defaultExpression("CURRENT_TIMESTAMP()")->append('ON UPDATE CURRENT_TIMESTAMP()'),
        ]);

        $this->batchInsert('user', ['username', 'email', 'password_hash', 'status', 'auth_key'], $this->getUserData());

    }

    public function getUserData()
    {
        return [
            ['admin', 'admin', Yii::$app->security->generatePasswordHash('admin'), 10, Yii::$app->security->generateRandomString()],
            ['user', 'user', Yii::$app->security->generatePasswordHash('user'), 10, Yii::$app->security->generateRandomString()],

        ];
    }

    public function down()
    {
        $this->dropTable('user');

        return false;
    }
}
