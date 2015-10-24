<?php
use yii\widgets\ListView;

?>
<div class="row container news-default-index">
    <?= ListView::widget([
			'dataProvider' => $dataProvider,
			'itemView' => '_item',
			'layout' => '<div class="row">{items}</div>{pager}',
	]); ?>
</div>
