<?php

namespace app\commands;

use app\rbac\IsOwnerRule;
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

        //owner rule
        $ownerRule = new IsOwnerRule();
        $auth->add($ownerRule);

        $viewOwnProfilePermission = $auth->createPermission('viewOwnProfile');
        $viewOwnProfilePermission->ruleName = $ownerRule->name;
        $auth->add($viewOwnProfilePermission);

        $viewProfilePermission = $auth->createPermission('viewProfile');
        $auth->add($viewProfilePermission);


        //user
        $user = $auth->createRole('user');
        $user->description = 'Write result of a calculation to history';

        $auth->add($user);
        $auth->addChild($user, $viewOwnProfilePermission);


        //admin
        $admin = $auth->createRole('administrator');
        $admin->description = 'Viewing, creating, deleting, changing users; viewing calculations of all users';

        $auth->add($admin);
        $auth->addChild($admin, $user);
        $auth->addChild($admin, $viewProfilePermission);


        //ownerRule
        $auth->addChild($viewOwnProfilePermission, $viewProfilePermission);


        //Assigning user routes
        $userRoutes = [
            '/calculator/*',

            '/history/index',
            '/history/view',
            '/history/error',

            '/user/profile',
            '/user/logout',
        ];

        foreach ($userRoutes as $route) {
            $perm = $auth->createPermission($route);
            $auth->add($perm);
            $auth->addChild($user, $perm);
        }

        //Assigning administrator routes
        $adminRoutes = [
            '/*',
        ];

        foreach ($adminRoutes as $route) {
            $perm = $auth->createPermission($route);
            $auth->add($perm);
            $auth->addChild($admin, $perm);
        }

        //assign
        $auth->assign($admin, 1);
        $auth->assign($user, 2);


        return ExitCode::OK;
    }

}