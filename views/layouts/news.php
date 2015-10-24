<?php
use yii\bootstrap\Nav;
use yii\helpers\Html;
use app\models\entity\Category;
?>
<?php $this->beginContent('@app/views/layouts/main.php'); ?>
<div class="container">
	<div class="col-xs-12 col-sm-2">
		<p>
			<h2>News</h2>
			<?php
				$items = [[
					'label' => 'All',
					'url' => ['/news/default/index','category'=>'all'],
				]];
				if ( !Yii::$app->user->isGuest ) $items[] = [
					'label' => 'My',
					'url' => ['/news/default/index','category'=>'my'],
				];
				$category = Category::find()->all();
				foreach($category as $c){
					$items[] = [
						'label' => $c->title,
						'url' => ['/news/default/index','category'=>$c->slug],
					];
				}
			?>
			<?php echo Nav::widget([
				'items' => $items,
				'options' => ['class' =>'nav-pills nav-stacked'],
			]);
			?>
		</p>
		<?php if(!Yii::$app->user->isGuest): ?>
		<p><?= Html::a('Create news', ['create'], ['class' => 'btn btn-success']) ?></p>
		<?php endif; ?>
	</div>
	<div id="content" class="col-xs-12 col-sm-10">
		<?php echo $content; ?>
	</div><!-- content -->
</div>
<?php $this->endContent(); ?>
