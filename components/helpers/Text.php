<?php
namespace app\components\helpers;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

class Text
{
	public static $transliteration = [
        'а' => 'a',   'б' => 'b',   'в' => 'v',
		'г' => 'g',   'д' => 'd',   'е' => 'e',
		'ё' => 'e',   'ж' => 'zh',  'з' => 'z',
		'и' => 'i',   'й' => 'y',   'к' => 'k',
		'л' => 'l',   'м' => 'm',   'н' => 'n',
		'о' => 'o',   'п' => 'p',   'р' => 'r',
		'с' => 's',   'т' => 't',   'у' => 'u',
		'ф' => 'f',   'х' => 'h',   'ц' => 'c',
		'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',
		'ь' => '',    'ы' => 'y',   'ъ' => '',
		'э' => 'e',   'ю' => 'yu',  'я' => 'ya',
		
		'А' => 'a',   'Б' => 'b',   'В' => 'v',
		'Г' => 'g',   'Д' => 'd',   'Е' => 'e',
		'Ё' => 'e',   'Ж' => 'zh',  'З' => 'z',
		'И' => 'i',   'Й' => 'y',   'К' => 'k',
		'Л' => 'l',   'М' => 'm',   'Н' => 'n',
		'О' => 'o',   'П' => 'p',   'Р' => 'r',
		'С' => 's',   'Т' => 't',   'У' => 'u',
		'Ф' => 'f',   'Х' => 'h',   'Ц' => 'c',
		'Ч' => 'ch',  'Ш' => 'sh',  'Щ' => 'sch',
		'Ь' => '',    'Ы' => 'y',   'Ъ' => '',
		'»' => '', '«' => '', '"' => '',
		'(' => '',    ')' => '',    '/' => '-',
		'Э' => 'e',   'Ю' => 'yu',  'Я' => 'ya', 
		' ' => '-', 
    ];
	
	public static $month = [
        1 => [ 1 => 'января', 2 => 'January'],
		2 => [ 1 => 'февраля', 2 => 'February'],
		3 => [ 1 => 'марта', 2 => 'March'],
		4 => [ 1 => 'апреля', 2 => 'April'],
		5 => [ 1 => 'мая', 2 => 'May'],
		6 => [ 1 => 'июня', 2 => 'June'],
		7 => [ 1 => 'июля', 2 => 'July'],
		8 => [ 1 => 'августа', 2 => 'August'],
		9 => [ 1 => 'сентября', 2 => 'September'],
		10=> [ 1 => 'октября', 2 => 'October'],
		11=> [ 1 => 'ноября', 2 => 'November'],
		12=> [ 1 => 'декабря', 2 => 'December']
    ];
	
	public static function transliterate($value)
	{
		$value = preg_replace('/[^(\w)|(\x7F-\xFF)|(\s)]/', '', $value);
		if(strlen($value) >= 250) $value = substr($value, 0, 250);
		return strtr($value, static::$transliteration);
	}
	
	public static function letter($value, $num = 1, $is_apper = true)
	{
		$value = mb_substr($value, 0, $num, 'UTF-8');
		if($is_apper)
		{
			$value = mb_strtoupper($value, 'UTF-8');
		}
		return $value;
	}
	
	public static function _toString($array = [])
	{
		$string = '';
		if($array && !empty($array))
		{
			foreach($array as $key => $value)
			{
				$string .= '<p>'.$key;
				
				if(is_array($value))
				{
					foreach($value as $item)
					{
						$string .= ' - '.$item.'<br>';
					}
				}
				else
				{
					$string .= ' - '.$value;
				}
				$string .= '</p>';
			}
		}
		return $string;
	}
	
	public static function _date($date, $delimiter = '.', $out_delimiter = ' ', $postfix = 'г.', $lang_id = 1)
	{
		$new_format_date = '';
		if(!empty($date))
		{
			$new_format_date_pre = Yii::$app->getFormatter()->format($date, 'date');
			$new_format_date_arr = explode($delimiter, $new_format_date_pre);
			
			if($new_format_date_arr AND is_array($new_format_date_arr))
			{
				foreach($new_format_date_arr as $key => $value)
				{
					if($key == 1)
					{
						$new_format_date .= $out_delimiter.static::$month[(int)$value][$lang_id];
					} 
					elseif($key > 1)
					{
						$new_format_date .= $out_delimiter.$value;
					} 
					else 
					{
						$new_format_date .= $value;
					}
				}
				
				if($lang_id == 1)
				{
					$new_format_date .= $postfix;
				}
			}
		}
		return $new_format_date;
	}
	
	public static function _edit($id = 0, $module = 'main')
	{
		$link = '';

		if(Yii::$app->user->can('adminPanel'))
		{
			//$currentUrl = Url::current();
			/* $script = <<< JS
			$('.popup-edit-link').on('click', function() {
				$('#modal_edit .modal-body-content').html('loading ...');
				$('#modal_edit').modal('show')
					.find('.modal-body-content')
					.load($(this).attr('data-target'));
					return false;
			});
			$('#modal_edit').on('shown.bs.modal', function (e) {
				$('#popup_edit_redirect').prop('value', '$currentUrl');
			});
JS;
			Yii::$app->view->registerJs($script, yii\web\View::POS_READY); */

			/***************************** Ссылка на редактирование в админку ***********************************/
			$link .= Html::a('<i class="edit-link fa fa-pencil"></i>', '/admin/'.$module.'/update?id='.$id, ['target' => '_blank', 'title' => 'Редактировать']);

			/***************************** Ссылка на редактирование в popup окно ***********************************/
			//$link .= Html::a('<i class="edit-link fa fa-pencil"></i>', '#', ['class' => 'popup-edit-link', 'data-target' => '/admin/'.$module.'/update-fast?id='.$id, 'title' => 'Редактировать']);
		}
		return $link;
	}
}