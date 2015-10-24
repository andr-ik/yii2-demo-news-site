<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user common\models\User */

$activateLink = Yii::$app->urlManager->createAbsoluteUrl(['user/activate', 'token' => $user->activate_token]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Follow the link below to activate your accaunt:</p>

    <p><?= Html::a(Html::encode($activateLink), $activateLink) ?></p>
</div>
