<?php
use yii\widgets\ListView;
use yii\helpers\Html;

?>
<div class="row container news-default-index">
    <?= ListView::widget([
			'dataProvider' => $dataProvider,
			'itemView' => '_item',
			'layout' => '<div class="row">{items}</div>{pager}',
			'options' => ['class'=>'col-xs-10']
	]); ?>
</div>
