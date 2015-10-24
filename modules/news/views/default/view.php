<?php
use yii\widgets\DetailView;

?>
<div class="row container news-default-index">
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
