<?php

namespace app\models;


use mdm\admin\components\UserStatus;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;


    public function rules()
    {
        return [
            ['username', 'required'],
            ['username', 'match', 'pattern' => '/^[a-zA-Z\s]+$/'],

            ['email', 'required'],
            ['email', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'email'],
            ['email', 'email'],

            ['password', 'required'],
            ['password', 'match',
                'pattern' => '/^(?=.*\d)(?=.*[a-zA-Z]).{8,14}$/',
                //(?=.*[a-z])(?=.*[A-Z])
                'message' => 'Пароль должен состоять из букв латинского алфавита (A-z), должна быть минимум 1 арабская цифра (0-9), длина пароля должна быть не менее 8 и не более 14 символов.'
            ],

            ['password_repeat', 'required'],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],

        ];
    }


    /**
     * @throws Exception
     * @throws \Exception
     */
    public function save()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->username;
            $user->email = $this->email;
            $user->status = UserStatus::ACTIVE;
            $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
            $user->generateAuthKey();
            $user->save();

            //assign role
            $auth = Yii::$app->authManager;
            $userRole = $auth->getRole('user');
            $auth->assign($userRole, $user->getId());

            return $user;
        }
        return null;
    }

    public function attributeLabels(): array
    {
        return [
            'email' => 'E-mail',
            'username' => 'Имя',
            'password' => 'Пароль',
            'password_repeat' => 'Повторите пароль',
        ];
    }


}