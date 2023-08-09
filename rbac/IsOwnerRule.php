<?php

namespace app\rbac;

use yii\rbac\Rule;

class IsOwnerRule extends Rule
{
    public $name = 'isOwner';

    public function execute($user, $item, $params)
    {

        return isset($params['owner_id']) && $params['owner_id'] == $user;
    }
}