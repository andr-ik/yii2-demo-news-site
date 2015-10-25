<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use app\rbac\UserRoleRule;
use app\rbac\EditNewsRule;
use app\rbac\ActiveNewsRule;
use app\models\entity\User;

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
		
		// Edit News
		$rule = new EditNewsRule();
        $am->add($rule);
		$editNews = Yii::$app->authManager->createPermission('editNews');
		$editNews->description = 'Право редактировать новость';
		$editNews->ruleName = $rule->name;
		$am->add($editNews);
		
		// Active News
		$setStatusActiveNews = Yii::$app->authManager->createPermission('setStatusActiveNews');
		$setStatusActiveNews->description = 'Право активировать новость';
		$am->add($setStatusActiveNews);
		
        $am->addChild($moderator, $user);
        $am->addChild($admin, $moderator);
		
		$am->addChild($user, $editNews);
		$am->addChild($moderator, $setStatusActiveNews);
    }
	
	public function actionSet($userId,$role)
	{
		Yii::$app->authManager->revokeAll($userId);
		$userRole = Yii::$app->authManager->getRole($role);
		Yii::$app->authManager->assign($userRole, $userId);
		$user = User::findOne($userId);
		
		$roles = [
			'user' => User::ROLE_USER,
			'moderator' => User::ROLE_MODERATOR,
			'admin' => User::ROLE_ADMIN
		];
		
		$user->role = $roles[$role] ?: 0;
		$user->save();
	}
}
