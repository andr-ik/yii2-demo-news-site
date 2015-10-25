<?php

namespace app\modules\user\controllers;

use Yii;
use yii\web\Controller;
use yii\web\BadRequestHttpException;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

use app\models\form\LoginForm;
use app\models\form\RegistrationForm;
use app\models\form\PasswordResetRequestForm;
use app\models\form\ResetPasswordForm;

use app\models\entity\User;

class DefaultController extends Controller
{
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'actions'=>['login','registration','logout','reset','reset-password','activate'],
						'roles' => ['?','@']
					],
					[
						'allow' => true,
						'actions'=>['list','view','create','update','delete'],
						'roles' => ['moderator'],
					],
				],
			],
		];
	}
	
	public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
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
		$user->activate_token = null;
		if( $user->save() ){
			Yii::$app->session->setFlash('success', 'You accaunt is activate.');
			Yii::$app->user->login($user, 0);
			return $this->goHome();
		}
	}
	
	public function actionList()
	{
		$dataProvider = new ActiveDataProvider([
			'query' => User::find(),
		]);

		return $this->render('index', [
			'dataProvider' => $dataProvider,
		]);
	}
	
	public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
	
	public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['list']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
        if ($model->load(Yii::$app->request->post())) {
			
			if ( $model->status ) $model->status = User::STATUS_ACTIVE;
			else $model->status = User::STATUS_DELETED;
			
			if ( $model->save() ){
				Yii::$app->authManager->revokeAll($model->id);
				$userRole = Yii::$app->authManager->getRole(User::$roles[$model->role]);
				Yii::$app->authManager->assign($userRole, $model->id);
				return $this->redirect(['list']);
			}
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['list']);
    }
	
	protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
