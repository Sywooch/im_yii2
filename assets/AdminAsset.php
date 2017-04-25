<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
		'css/backend.css',
    ];
	
	// атрибуты подключения css файлов (применяются ко всем перечисленным в массиве $css файлам)
	//public $cssOptions = ['conditon' => 'lte IE8'];
	
    public $js = [
		'js/backend/main.js',
	];
	
	// Подключение дополнительных классов Asset
    public $depends = [
        'yii\web\YiiAsset',
		'yii\bootstrap\BootstrapAsset',
    ];
}