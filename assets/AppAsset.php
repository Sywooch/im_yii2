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
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
	
    public $css = [
		'js/vendor/fancybox/jquery.fancybox.css',
        'css/animate.css',
		'css/jquery-ui.min.css',
		'css/meanmenu.min.css',
		'css/owl.carousel.css',
		'js/vendor/nivoslider/nivo-slider.css',
		'css/font-awesome.min.css',
		'css/eleganticons.css',
		'css/style.css',
		'css/responsive.css',
		'css/main2.css',
		'css/site.css',
    ];
	
    public $js = [
		'js/owl.carousel.min.js',
        'js/jquery.meanmenu.js',
		'js/jquery-ui.min.js',
        'js/wow.min.js',
		'js/vendor/fancybox/jquery.fancybox.pack.js',
       
		'js/jquery.maskedinput.js',
        'js/vendor/nivoslider/jquery.nivo.slider.pack.js',
		'js/vendor/nivoslider/nivo-active.js',
		
		'js/plugins.js',
		'js/main.js',
    ];
	
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
