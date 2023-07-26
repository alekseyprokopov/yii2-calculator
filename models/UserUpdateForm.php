<?php

namespace app\models;

use yii\base\Model;
use Yii;

class UserUpdateForm extends User
{
    //ПЕРЕНЕСТИ!!!!
    public $id;
    public $name;
    public $email;
    public $role;
    /**
     * @var User
     */
    private $_user;

    public function __construct(User $user = null)
    {
        $this->_user = $user;
        $this->id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = User::getRoleById($this->id);
    }

    public function updateProfile()
    {
        if ($this->validate()) {
            $manager = Yii::$app->authManager;
            $user = $this->_user;
            $user->name = $this->name;
            $user->email = $this->email;

            $manager->revokeAll($user->id);
            $userRole = $manager->getRole($this->role);
            $manager->assign($userRole, $user->getId());

            return $user->save();
        }
        return false;
    }

    public function rules()
    {
        return [
            ['id', 'integer'],

            ['name', 'required'],
            ['name', 'match', 'pattern' => '/^[a-zA-Z\s]+$/'],

            ['email', 'uniqueByEmail'],
            ['email', 'required'],
            ['email', 'email'],

            ['role', 'in', 'range' => ['administrator', 'user']],
            ['role', 'safe'],
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
            'name' => 'Имя',
            'email' => 'E-mail',
        ];
    }
}