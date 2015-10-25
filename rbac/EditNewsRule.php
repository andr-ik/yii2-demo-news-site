<?php

namespace app\rbac;

use Yii;
use yii\rbac\Rule;

use app\models\entity\User;

class EditNewsRule extends Rule
{
    public $name = 'EditNews';
	
    public function execute($user, $item, $params)
    {	
		$model = $params['model'] ?: null;
		$user = Yii::$app->user->identity;
		
        if($model){
			// либо модератор либо автор новости
            return in_array($user->role,[User::ROLE_ADMIN,User::ROLE_MODERATOR]) || $model->author_id === $user->id;
        }
        return false;
    }
}