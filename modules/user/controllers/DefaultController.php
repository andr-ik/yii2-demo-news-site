<?php

namespace app\modules\user\controllers;

use Yii;
use yii\web\Controller;
use yii\web\BadRequestHttpException;
use yii\base\InvalidParamException;

use app\models\form\LoginForm;
use app\models\form\RegistrationForm;
use app\models\form\PasswordResetRequestForm;
use app\models\form\ResetPasswordForm;

use app\models\entity\User;

class DefaultController extends Controller
{
	public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }
	
	public function actionRegistration()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegistrationForm();
        if ($model->load(Yii::$app->request->post()) && $model->registration()) {
            return $this->goBack();
        }
        return $this->render('registration', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
	
	public function actionReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }
	
	public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
	
	public function actionActivate($token){
		$user = User::findByActivateToken($token);
		if ( !$user ) throw new InvalidParamException('Wrong password reset token.');
		$user->status = User::STATUS_ACTIVE;
		if( $user->save() ){
			Yii::$app->session->setFlash('success', 'You accaunt is activate.');
			Yii::$app->user->login($user, 0);
			return $this->goHome();
		}
	}
}
