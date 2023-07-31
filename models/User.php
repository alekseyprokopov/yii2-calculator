<?php

namespace app\models;

use mdm\admin\components\UserStatus;
use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property int $status
 * @property string $auth_key
 */
class User extends ActiveRecord implements IdentityInterface
{

    public function rules()
    {
        return [
            ['status', 'in', 'range' => [UserStatus::ACTIVE, UserStatus::INACTIVE]],
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => UserStatus::ACTIVE]);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => UserStatus::ACTIVE]);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function getRole()
    {
        return Yii::$app->authManager->checkAccess($this->id, 'administrator') ? 'administrator' : 'user';
    }

    public function getCalculationsCount()
    {
        return History::find()
            ->where(['user_id' => $this->id])
            ->count();
    }

    public function getRegistrationData()
    {
        return User::find()->select(['created_at'])
            ->where(['id' => $this->id])
            ->scalar();
    }


    public static function findByEmail($email)
    {
        return User::findOne(['email' => $email]);
    }

    public static function getEmailById($id)
    {
        return User::find()->select(['email'])
            ->where(['id' => $id])
            ->scalar();
    }

}
