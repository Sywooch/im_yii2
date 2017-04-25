<?php
namespace app\modules\user\models\forms;

use app\modules\user\models\User;
use yii\base\Model;
use yii\helpers\Html;
use Yii;

/**
 * Signup form
 */
class FormSignup extends Model
{
    public $username;
	public $name;
    public $email;
    public $password;
	
    public $verifyCode;
    private $_defaultRole;
	
	public $sitename;
	public $date;
	public $link;
	
	public $post;
	public $profile_post;

    public function __construct($defaultRole, $config = [])
    {
        $this->_defaultRole = $defaultRole;
        parent::__construct($config);
    }
 
    public function rules()
    {
		$this->post = Yii::$app->request->post('FormSignup');
		$this->profile_post = Yii::$app->request->post('Profile');
		
        return [
			[['username'], 'safe'],
			
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::className(), 'message' => 'Этот Email уже зарегистрирован.'],
 
            ['password', 'required'],
            ['password', 'string', 'min' => 5, 'message' => 'Пароль должен быть более 5-и символов.'],
			
			[['username'], 'default', 'value' => $this->post['email']],
 
            ['verifyCode', 'captcha', 'captchaAction' => '/user/default/captcha'],
        ];
    }
	
	public function attributeLabels()
    {
        return [
            'username' => Yii::t('app', 'FORM_LOGIN'),
            'password' => Yii::t('app', 'FORM_PW'),
			'email' => Yii::t('app', 'FORM_EMAIL'),
			'verifyCode' => Yii::t('app', 'FORM_VERIFY_CODE'),
        ];
    }
 
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if ($this->validate()) {
            $user = new User();
            $user->username = $this->email; //$this->username;
            $user->email = $this->email;
            $user->setPassword($this->password);
            $user->status = User::STATUS_WAIT;
            $user->role = $this->_defaultRole;
            $user->generateAuthKey();
            $user->generateEmailConfirmToken();
 
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
				$emailTemp = \app\modules\emailtemp\components\BlockEmailtemp::_(1);
				
				$this->sitename = Yii::$app->view->params['siteinfo']->title;
				$confirmLink = Yii::$app->urlManager->createAbsoluteUrl(['user/default/email-confirm', 'token' => $user->email_confirm_token]);
				$this->link = Html::a(Html::encode($confirmLink), $confirmLink);
				$this->name = $this->profile_post['name'];
				
				if($emailTemp)
				{
					foreach(\app\modules\emailtemp\models\Emailtemp::getVarsArray() as $var => $d)
					{
						$emailTemp->subject = str_replace('['.$var.']', (isset($this->{$var}))?$this->{$var}:'', $emailTemp->subject);
						$emailTemp->body = str_replace('['.$var.']', (isset($this->{$var}))?$this->{$var}:'', $emailTemp->body);
					}
					
					$mailer->compose()
					->setTo($this->email)
					->setFrom([$setFrom => $this->sitename])
					->setReplyTo([$setFrom => $this->sitename])
					->setSubject($emailTemp->subject)
					->setHtmlBody($emailTemp->body)
					->send();
				}
				else
				{
					$mailer->compose('@app/modules/user/mails/emailConfirm', ['user' => $user])
                    ->setFrom([$setFrom => $this->sitename])
                    ->setTo($this->email)
					->setReplyTo([$setFrom => $this->sitename])
                    ->setSubject('Подтверждение Email при регистрации на ' . $this->sitename)
                    ->send();
				}
            }
            return $user;
        }
 
        return null;
    }
}