<?php

namespace app\modules\search\models\forms;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FormSearch extends Model
{
    public $q;
	
	/**
     * Имя Формы, по умолчанию имя модели. Если нужно только имя поля(без имени формы), вернуть пустую строку.
     */
	public function formName()
    {
        return '';
    }

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['q'], 'required', 'message' => 'Введите Ваш поисковой запрос.'],
			[['q'], 'string'],
        ];
    }
}
