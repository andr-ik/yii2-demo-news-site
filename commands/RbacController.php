<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\rbac\UserRoleRule;

class RbacController  extends Controller
{
    public function actionInit()
    {
		$am = Yii::$app->authManager;
        $am->removeAll();
		
        $rule = new UserRoleRule();
        $am->add($rule);
		
        // user
        $user = $am->createRole('user');
        $user->description = 'Пользователь';
		$user->ruleName = $rule->name;
        $am->add($user);
        
		// moderator
		$moderator = $am->createRole('moderator');
        $moderator->description = 'Модератор';
		$moderator->ruleName = $rule->name;
        $am->add($moderator);
		
		// moderator
		$admin = $am->createRole('admin');
        $admin->description = 'Админ';
        $admin->ruleName = $rule->name;
        $am->add($admin);
		
        $am->addChild($moderator, $user);
        $am->addChild($admin, $moderator);
    }
	
	public function actionSet($userId,$role)
	{
		Yii::$app->authManager->revokeAll($userId);
		$userRole = Yii::$app->authManager->getRole($role);
		Yii::$app->authManager->assign($userRole, $userId);
	}
}
