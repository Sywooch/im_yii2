<?php
namespace app\components;

use yii\helpers\Url;

class redactorSetting
{
	public static function _($Id, $imagesDirectory)
	{
		return [
			'lang' => 'ru',
			'minHeight' => 200,
			'replaceDivs' => false,
			'paragraphize' => false,
			'allowedTags' => false,
			
			'cleanOnPaste' => false,
			'cleanSpaces' => false,
		
			'verifiedTags' => ['a', 'img', 'b', 'strong', 'sub', 'sup', 'i', 'em', 'u', 'small', 'strike', 'del', 'cite', 'ul', 'ol', 'li', 'font'], // and for span tag special rule
			'inlineTags' =>	['strong', 'b', 'u', 'em', 'i', 'code', 'del', 'ins', 'samp', 'kbd', 'sup', 'sub', 'mark', 'var', 'cite', 'small', 'font'],
			'formattingAdd' => [
				0 => [
					'title' => 'Блок 100% зеленая рамка',
					'type' => 'block',
					'tag' => 'p',
					'class' => 'mark-1',
					'clear' => 'remove',
				],
				1 => [
					'title' => 'Блок 100% зеленый фон',
					'type' => 'block',
					'tag' => 'p',
					'class' => 'mark-2',
					'clear' => 'remove',
				],
				2 => [
					'title' => 'Блок (!) слева 55% зеленый фон',
					'type' => 'block',
					'tag' => 'p',
					'class' => 'mark-3',
					'clear' => 'remove',
				],
				3 => [
					'title' => 'Блок (!) справа 55% зеленый фон',
					'type' => 'block',
					'tag' => 'p',
					'class' => 'mark-3-right',
					'clear' => 'remove',
				],
				4 => [
					'title' => 'Блок (%) слева 55% зеленый фон',
					'type' => 'block',
					'tag' => 'p',
					'class' => 'mark-4',
					'clear' => 'remove',
				],
				5 => [
					'title' => 'Блок (%) справа 55% зеленый фон',
					'type' => 'block',
					'tag' => 'p',
					'class' => 'mark-4-right',
					'clear' => 'remove',
				],
				6 => [
					'title' => 'Блок (?) слева 55% зеленый фон',
					'type' => 'block',
					'tag' => 'p',
					'class' => 'mark-5',
					'clear' => 'remove',
				],
				7 => [
					'title' => 'Блок (?) справа 55% зеленый фон',
					'type' => 'block',
					'tag' => 'p',
					'class' => 'mark-5-right',
					'clear' => 'remove',
				],
				8 => [
					'title' => 'Блок («») слева 55% зеленый фон',
					'type' => 'block',
					'tag' => 'p',
					'class' => 'mark-6',
					'clear' => 'remove',
				],
				9 => [
					'title' => 'Блок («») справа 55% зеленый фон',
					'type' => 'block',
					'tag' => 'p',
					'class' => 'mark-6-right',
					'clear' => 'remove',
				],
				10 => [
					'title' => 'Списки (оранжевые точки)',
					'type' => 'block',
					'tag' => 'ul',
					'class' => 'list-1',
					'clear' => 'remove',
				],
				11 => [
					'title' => 'Списки (белые точки)',
					'type' => 'block',
					'tag' => 'ul',
					'class' => 'list-2',
					'clear' => 'remove',
				]
			],
			'imageManagerJson' => Url::to(['/backend/images-get', 'id' => $Id, 'imagesDirectory' => $imagesDirectory]),
			'imageUpload' => Url::to(['/backend/image-upload', 'id' => $Id, 'imagesDirectory' => $imagesDirectory]),
			'fileManagerJson' => Url::to(['/backend/files-get', 'id' => $Id, 'imagesDirectory' => $imagesDirectory]),
			'fileUpload' => Url::to(['/backend/file-upload', 'id' => $Id, 'imagesDirectory' => $imagesDirectory]),
			'plugins' => [
				'imagemanager',
				'filemanager',
				'video',
				'table',
				'accordion',
				'definedlinks',
				'fullscreen'
			]
		];
	}
}