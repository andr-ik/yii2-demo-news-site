<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <!--<?= $form->field($model, 'image')->textInput(['maxlength' => true]) ?>-->

    <?= $form->field($model, 'short')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'text')->textarea(['rows' => 6]) ?>

	<?= $form->field($model, 'category_id')->dropDownList($category,['prompt'=>'Select category']); ?>
	
    <!--<?= $form->field($model, 'status')->checkBox() ?>-->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
