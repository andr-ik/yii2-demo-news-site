<?php
use yii\helpers\Html;
?>
<li class="col-xs-12">
	<h2><?= Html::encode($model->title); ?></h2>
	<p><?= Html::encode($model->short); ?></p>
	<?= Html::a('view', ['view', 'slug' => $model->slug]); ?>
	
	<?php if(Yii::$app->user->can('editNews',['model'=>$model])): ?>
	<?= Html::a('edit', ['update', 'slug' => $model->slug]); ?>
	<?= Html::a('delete', ['delete', 'slug' => $model->slug]); ?>
	<?php endif; ?>
</li>