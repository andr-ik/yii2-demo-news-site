<?php

namespace app\rbac;

use Yii;
use yii\rbac\Rule;

use app\models\entity\User;

class UserRoleRule extends Rule
{
    public $name = 'userRole';
	
    public function execute($user, $item, $params)
    {	
		$user = Yii::$app->user->identity;
		
        if($user){
            switch($item->name){
				case 'user':      return in_array($user->role,[User::ROLE_ADMIN,User::ROLE_MODERATOR,User::ROLE_USER,]);
				case 'moderator': return in_array($user->role,[User::ROLE_ADMIN,User::ROLE_MODERATOR]);
				case 'admin':     return in_array($user->role,[User::ROLE_ADMIN]);
				default: return false;
			}
        }
        return false;
    }
}