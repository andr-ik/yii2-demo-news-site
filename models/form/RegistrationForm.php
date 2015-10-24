<?php
namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\entity\User;

class RegistrationForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password_repeat;

    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            ['username', 'required'],
            ['username', 'unique', 'targetClass' => 'app\models\entity\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => 'app\models\entity\User', 'message' => 'This email address has already been taken.'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
			
			['password_repeat', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    public function registration()
    {
        if ($this->validate()) {
			$user = new User();
			
            $user->username = $this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
			$user->generateActivationToken();
			
            if ($user->save()) {
				
				Yii::$app->mailer
					->compose(['html' => 'userActivateToken-html', 'text' => 'userActivateToken-text'], ['user' => $user])
                    ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
                    ->setTo($user->email)
                    ->setSubject('Activate accaunt for ' . Yii::$app->name)
                    ->send();
				
				if ( $user->status !== User::STATUS_ACTIVE ){
					Yii::$app->session->setFlash('success', 'Please, activate your accaunt');
					return true;
				}
            }
        } else {
            return false;
        }
    }
}
