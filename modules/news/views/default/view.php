<?php
use yii\widgets\DetailView;

$this->title = 'View News';
$this->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->title;
?>
<div class="row container news-default-index col-xs-12">
    <?= DetailView::widget([
			'model' => $model,
			'attributes' => [
				'title',
				'text',
				[
					'label' => 'Category',
					'value' => $model->getCategory()->one()->title
				],
				'created_at:datetime',
				'updated_at:datetime',
			],
	]); ?>
</div>
