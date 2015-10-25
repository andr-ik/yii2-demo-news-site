<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use yii\helpers\ArrayHelper;
use app\models\entity\User;

/* @var $this yii\web\View */
/* @var $model app\models\entity\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>
	
    <?= $form->field($model, 'username')->textInput() ?>
    <?= $form->field($model, 'email')->textInput() ?>
	
	<?php $roles = [
		User::ROLE_USER=>'user',
		User::ROLE_MODERATOR=>'moderator',
		User::ROLE_ADMIN=>'admin',
	] ?>
	
	<?= $form->field($model, 'role')->dropDownList($roles,['prompt'=>'Select category']); ?>
	
    <?= $form->field($model, 'status')->checkbox() ?>
	

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
