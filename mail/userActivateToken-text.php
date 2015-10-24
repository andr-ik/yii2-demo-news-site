<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

$activateLink = Yii::$app->urlManager->createAbsoluteUrl(['user/activate', 'token' => $user->activate_token]);
?>
Hello <?= $user->username ?>,

Follow the link below to activate your accaunt:

<?= $activateLink ?>
