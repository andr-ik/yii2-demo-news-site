<?php
use yii\helpers\Html;

?>
<li class="col-xs-12 col-sm-6">
	<h2><?= Html::encode($model->title); ?></h2>
	<p><?= Html::encode($model->short); ?></p>
	<?= Html::a('Подробнее', ['view', 'slug' => $model->slug]); ?>
</li>