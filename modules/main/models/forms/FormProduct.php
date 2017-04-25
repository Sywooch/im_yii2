<?php

namespace app\modules\main\models\forms;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FormProduct extends Model
{
    public $name;
    public $phone;
	public $email;
    public $text;
	public $product_id;
	public $sitename;
	public $date;
	public $target;
	public $order;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'phone', 'email'], 'required', 'message' => 'Надо бы заполнить это поле'],
			[['email'], 'email', 'message' => 'Некорректный E-mail адрес'],
			[['name', 'phone'], 'string'],
			[['product_id'], 'integer'],
			[['text'], 'string'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
			'email' => 'E-mail',
            'phone' => 'Номер телефона',
            'text' => 'Комментарий к заказу',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param  string  $email the target email address
     * @return boolean whether the model passes validation
     */
    public function send($email, $product = null)
    {
		$this->sitename = Yii::$app->view->params['siteinfo']->title;
		$this->target = (isset($product->title))?$product->title.'('.$product->price.'р.).':'';
		$this->order = (isset($product->title))?$product->title.'('.$product->price.'р.).':'';
			
        if ($this->validate()) 
		{
			$html1 = '';
			$html2 = 'Здравствуйте '.$this->name.'! Вы заказали товар '.$product->title.'('.$product->price.'р.) на сайте '.$this->sitename;
			
			if($product){
				$html1 .= 'Товар: '.$product->title.'('.$product->price.'р.).';
			} else {
				$html1 .= 'Товар не определен.';
			}
			
			$html1 .= '<br><br>Имя заказчика: '.$this->name;
			$html1 .= '<br>Номер телефона: '.$this->phone;
			$html1 .= '<br>E-mail адрес: '.$this->email;
			$html1 .= '<br><br>Комментарий к заказу: '.$this->text;
			
			$mailer1 = Yii::$app->mailer;
			$mailer2 = Yii::$app->mailer;
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
				
				$mailer1->setTransport($transport);
				$mailer2->setTransport($transport);
				$setFrom = Yii::$app->view->params['setting']['smtp_username'];
			}
			
			// Шаблон для админа
			$emailTemp1 = \app\modules\emailtemp\components\BlockEmailtemp::_(28); //31 - наблон для клиента
			
			// Шаблон для заказчика
			$emailTemp2 = \app\modules\emailtemp\components\BlockEmailtemp::_(31); //31 - наблон для клиента
			
			// Отправка почты администратору
            if($emailTemp1)
			{
				foreach(\app\modules\emailtemp\models\Emailtemp::getVarsArray() as $var => $d)
				{
					$emailTemp1->subject = str_replace('['.$var.']', (isset($this->{$var}))?$this->{$var}:'', $emailTemp1->subject);
					$emailTemp1->body = str_replace('['.$var.']', (isset($this->{$var}))?$this->{$var}:'', $emailTemp1->body);
				}
				
				$mailer1->compose()
				->setTo($email)
				->setFrom([$setFrom => $this->sitename])
				->setReplyTo([$setFrom => $this->sitename])
				->setSubject($emailTemp1->subject)
				->setHtmlBody($emailTemp1->body)
				->send();
			}
			else
			{
				$mailer1->compose()
                ->setTo($email)
                ->setFrom([$setFrom => $this->sitename])
                ->setReplyTo([$setFrom => $this->sitename])
                ->setSubject('Заказ товара')
                ->setHtmlBody($html1)
                ->send();
			}
			
			// Отправка почты заказчику
			if($emailTemp2)
			{
				foreach(\app\modules\emailtemp\models\Emailtemp::getVarsArray() as $var => $d)
				{
					$emailTemp2->subject = str_replace('['.$var.']', (isset($this->{$var}))?$this->{$var}:'', $emailTemp2->subject);
					$emailTemp2->body = str_replace('['.$var.']', (isset($this->{$var}))?$this->{$var}:'', $emailTemp2->body);
				}
				
				$mailer2->compose()
				->setTo($this->email)
				->setFrom([$setFrom => $this->sitename])
				->setReplyTo([$setFrom => $this->sitename])
				->setSubject($emailTemp2->subject)
				->setHtmlBody($emailTemp2->body)
				->send();
			}
			else
			{
				$mailer2->compose()
                ->setTo($this->email)
                ->setFrom([$setFrom => $this->sitename])
                ->setReplyTo([$setFrom => $this->sitename])
                ->setSubject('Заказ товара')
                ->setHtmlBody($html2)
                ->send();
			}
            return true;
        } 
		else 
		{
            return false;
        }
    }
}
