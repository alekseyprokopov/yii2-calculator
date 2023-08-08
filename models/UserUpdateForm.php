<?php

namespace app\models;

use Yii;

class UserUpdateForm extends User
{
    //ПЕРЕНЕСТИ!!!!
    public $id;
    public $username;
    public $email;

    private ?User $_user;

    public function __construct(User $user = null)
    {
        $this->_user = $user;
        $this->id = $user->id;
        $this->username = $user->username;
        $this->email = $user->email;
    }

    public function updateProfile()
    {
        if ($this->validate()) {
            $user = $this->_user;
            $user->username = $this->username;
            $user->email = $this->email;

            return $user->save();
        }
        return false;
    }

    public function rules()
    {
        return [
            ['id', 'integer'],

            ['username', 'required'],
            ['username', 'match', 'pattern' => '/^[a-zA-Z\s]+$/'],

            ['email', 'uniqueByEmail'],
            ['email', 'required'],
            ['email', 'email'],

        ];
    }

    public function uniqueByEmail($attribute, $params)
    {
        if (User::getEmailById($this->id) === $this->email || User::findByEmail($this->email) === null) {
            return;
        }
        $this->addError($attribute, 'Такой Email уже занят');
    }

    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'username' => 'Имя',
            'email' => 'E-mail',
        ];
    }
}