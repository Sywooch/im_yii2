<?php
namespace app\modules\user\models\forms;

use app\modules\user\models\User;
use yii\base\Model;
use yii\helpers\Html;
use Yii;

/**
 * Password reset request form
 */
class FormPasswordResetRequest extends Model
{
    public $email;
	public $name;
	public $link;
	public $sitename;
	public $date;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'exist',
                'targetClass' => 'app\modules\user\models\User',
                'filter' => ['status' => User::STATUS_ACTIVE],
                'message' => 'There is no user with such email.'
            ],
        ];
    }
	
	public function attributeLabels()
    {
        return [
			'email' => Yii::t('app', 'FORM_EMAIL'),
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'email' => $this->email,
        ]);

        if ($user) {
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }

            if ($user->save()) {
			
				$mailer = Yii::$app->mailer;
				$setFrom = Yii::$app->view->params['siteinfo']->email;
				
				if(isset(Yii::$app->view->params['setting']) && !empty(Yii::$app->view->params['setting']) && isset(Yii::$app->view->params['setting']['smtp_host']) && !empty(Yii::$app->view->params['setting']['smtp_host'])){
					$transport = [
						'class' => 'Swift_SmtpTransport',
						'host' => Yii::$app->view->params['setting']['smtp_host'],
						'username' => Yii::$app->view->params['setting']['smtp_username'],
						'password' => Yii::$app->view->params['setting']['smtp_password'],
						'port' => Yii::$app->view->params['setting']['smtp_port'],
						'encryption' => Yii::$app->view->params['setting']['smtp_encryption'],
					];
					
					$mailer->setTransport($transport);
					$setFrom = Yii::$app->view->params['setting']['smtp_username'];
				}
				
				// Шаблон
				$emailTemp = \app\modules\emailtemp\components\BlockEmailtemp::_(7);
				
				$this->sitename = Yii::$app->view->params['siteinfo']->title;
				$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['user/default/password-reset', 'token' => $user->password_reset_token]);
				$this->link = Html::a(Html::encode($resetLink), $resetLink);
				$this->name = $user->profile->name;
				
				if($emailTemp)
				{
					foreach(\app\modules\emailtemp\models\Emailtemp::getVarsArray() as $var => $d)
					{
						$emailTemp->subject = str_replace('['.$var.']', (isset($this->{$var}))?$this->{$var}:'', $emailTemp->subject);
						$emailTemp->body = str_replace('['.$var.']', (isset($this->{$var}))?$this->{$var}:'', $emailTemp->body);
					}
					
					return $mailer->compose()
					->setTo($this->email)
					->setFrom([$setFrom => $this->sitename])
					->setReplyTo([$setFrom => $this->sitename])
					->setSubject($emailTemp->subject)
					->setHtmlBody($emailTemp->body)
					->send();
				}
				else
				{
					return $mailer->compose('@app/modules/user/mails/passwordReset', ['user' => $user], ['html' => 'passwordResetToken-html', 'text' => 'passwordResetToken-text'])
                    ->setFrom([$setFrom => $this->sitename . ' robot'])
					->setReplyTo([$setFrom => $this->sitename])
                    ->setTo($this->email)
                    ->setSubject('Восстановление пароля на ' . $this->sitename)
                    ->send();
				}
            }
        }
        return false;
    }
}
