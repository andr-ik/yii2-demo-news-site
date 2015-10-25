<?php

use yii\helpers\Html;
use yii\grid\GridView;

use app\models\entity\User;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'email:email',
			[
				'attribute' => 'status',
				'content' => function($data){
					$status = [
						User::STATUS_DELETED => 'deleted',
						User::STATUS_ACTIVE => 'active'
					];
					return $status[$data->status];
				}
			],
            'created_at:date',
			[
				'attribute' => 'role',
				'content' => function($data){
					$status = [
						User::ROLE_USER => 'user',
						User::ROLE_MODERATOR => 'moderator',
						User::ROLE_ADMIN => 'admin'
					];
					return $status[$data->role];
				}
			],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
