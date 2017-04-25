<?php
namespace app\modules\user\models\forms;
use app\modules\user\models\User; 
use yii\base\Model;
use Yii;
 
/**
 * Password reset form
 */
class FormPasswordChange extends Model
{
    public $currentPassword;
    public $newPassword;
    public $newPasswordRepeat;
	public $name;
	public $email;
	public $password;
	public $sitename;
	public $date;
 
    /**
     * @var User
     */
    private $_user;
 
    /**
     * @param User $user
     * @param array $config
     */
    public function __construct(User $user, $config = [])
    {
        $this->_user = $user;
        parent::__construct($config);
    }
 
    public function rules()
    {
        return [
            [['currentPassword', 'newPassword', 'newPasswordRepeat'], 'required'],
            ['currentPassword', 'validatePassword'],
            ['newPassword', 'string', 'min' => 5],
            ['newPasswordRepeat', 'compare', 'compareAttribute' => 'newPassword'],
        ];
    }
 
    public function attributeLabels()
    {
        return [
			'currentPassword' => 'Текущий пароль',
            'newPassword' => 'Новый пароль',
            'newPasswordRepeat' => 'Повторите новый пароль',
        ];
    }
 
    /**
     * @param string $attribute
     * @param array $params
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!$this->_user->validatePassword($this->$attribute)) {
                $this->addError($attribute, 'Неверный пароль');
            }
        }
    }
 
    /**
     * @return boolean
     */
    public function changePassword()
    {
        if ($this->validate()) {
            $user = $this->_user;
            $user->setPassword($this->newPassword);
			
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
				$emailTemp = \app\modules\emailtemp\components\BlockEmailtemp::_(8);
				
				$this->sitename = Yii::$app->view->params['siteinfo']->title;
				$this->email = $user->email;
				$this->password = $this->newPassword;
				$this->name = $user->profile->name;
				
				if($emailTemp)
				{
					foreach(\app\modules\emailtemp\models\Emailtemp::getVarsArray() as $var => $d)
					{
						$emailTemp->subject = str_replace('['.$var.']', (isset($this->{$var}))?$this->{$var}:'', $emailTemp->subject);
						$emailTemp->body = str_replace('['.$var.']', (isset($this->{$var}))?$this->{$var}:'', $emailTemp->body);
					}
					
					$mailer->compose()
					->setTo($user->email)
					->setFrom([$setFrom => $this->sitename])
					->setReplyTo([$setFrom => $this->sitename])
					->setSubject($emailTemp->subject)
					->setHtmlBody($emailTemp->body)
					->send();
				}
				else
				{
					$mailer->compose('@app/modules/user/mails/passwordChange', ['user' => $user, 'newPassword' => $this->newPassword])
                    ->setFrom([$setFrom => $this->sitename])
                    ->setTo($user->email)
                    ->setSubject('Изменение пароля для доступа в личный кабинет на ' . $this->sitename)
                    ->send();
				}
            }
            return $user;
					
        } else {
            return false;
        }
    }
}