<?php

namespace app\commands;

use Exception;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

class RbacController extends Controller
{
    /**
     * @throws Exception
     */
    public function actionInit()
    {
        $auth = Yii::$app->authManager;


        //выполнение расчёта
        $performCalculation = $auth->createPermission('performCalculation');
        $performCalculation->description = 'Perform a calculation';
        $auth->add($performCalculation);

        //запись в историю
        $writeHistory = $auth->createPermission('writeHistory');
        $writeHistory->description = 'Write result of a calculation to history';
        $auth->add($writeHistory);

        //права админа
        $adminPermission = $auth->createPermission('adminPermission');
        $adminPermission->description = 'Viewing, creating, deleting, changing users; viewing calculations of all users';
        $auth->add($adminPermission);


        $guest = $auth->createRole('guest');
        $auth->add($guest);
        $auth->addChild($guest, $performCalculation);

        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $guest);
        $auth->addChild($user, $writeHistory);

        $admin = $auth->createRole('administrator');
        $auth->add($admin);
        $auth->addChild($admin, $user);
        $auth->addChild($admin, $adminPermission);


        return ExitCode::OK;
    }

}