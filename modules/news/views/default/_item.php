<?php
use yii\helpers\Html;
?>
<li class="col-xs-12">
	<h2><?= Html::encode($model->title); ?></h2>
	<p><?= Html::encode($model->short); ?></p>
	<?= Html::a('view', ['view', 'slug' => $model->slug]); ?>
	<?= Html::a('edit', ['update', 'slug' => $model->slug]); ?>
</li>