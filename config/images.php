<?php
//use app\modules\file\components\Thumbnailer;

// откуда будем резать тамб у картинки
/**
* 0 - Если картинка вертикальная - то миниатюра будет браться сверху, если горизонтальная - слева.
* (Имеет смысл только при типе "2", в других случаях миниатюра
* всегда будет полностью видима)
*/

/**
* 1 - Миниатюра будет взята с центра картинки
*/

/**
* 2 - Если картинка вертикальная - то миниатюра будет браться снизу, если горизонтальная - справа.
* (Имеет смысл только при типе "0", в других случаях миниатюра
* всегда будет полностью видима)
*/

// как будем резать тамб
/**
* 0 - Миниатюра будет строго указанного размера, если соотношения сторон исходного изображения и
* миниатюры не совпадают - то останутся полосы указанного цвета.
*/
 
/**
* 1 - Одна из сторон миниатюры будет строго заданного размера, а другая - меньше настолько,
* чтобы совпало соотношение сторон.
*/

/**
* 2 - Миниатюра будет строго указанного размера и на ней не будет полос, но если соотношения
* сторон миниатюры и исходного изображения не совпадут, то миниатюра будет содержать не всю
* картинку, а только её часть.
* (Какая часть будет содержаться в миниатюре указывается параметром Thumbnailer::THUMBNAIL_LOCATION_*)
*/

return [
    'versions' => [
		'full-width' => [
            'uploadDir' => 'full-width/',
            'width' => 1800,
            'height' => FALSE,
			'locationMode' => 1,// Thumbnailer::THUMBNAIL_LOCATION_CENTER,
			'typeMode' => 1, //Thumbnailer::THUMBNAIL_TYPE_AUTO_SIZE,
            'quality' => 100,
			'isDefault' => FALSE,
        ],
		'extralarge' => [
            'uploadDir' => 'extralarge/',
            'width' => 1100,
            'height' => FALSE,
			'locationMode' => 1,// Thumbnailer::THUMBNAIL_LOCATION_CENTER,
			'typeMode' => 1, //Thumbnailer::THUMBNAIL_TYPE_AUTO_SIZE,
            'quality' => 100,
			'isDefault' => FALSE,
        ],
		'vertical-large' => [
            'uploadDir' => 'vertical-large/',
            'width' => FALSE,
            'height' => 1000,
			'locationMode' => 1,// Thumbnailer::THUMBNAIL_LOCATION_CENTER,
			'typeMode' => 2, //Thumbnailer::THUMBNAIL_TYPE_AUTO_SIZE,
            'quality' => 100,
			'isDefault' => FALSE,
        ],
		'large' => [
            'uploadDir' => 'large/',
            'width' => 500,
            'height' => FALSE,
			'locationMode' => 1,// Thumbnailer::THUMBNAIL_LOCATION_CENTER,
			'typeMode' => 1, //Thumbnailer::THUMBNAIL_TYPE_AUTO_SIZE,
            'quality' => 100,
			'isDefault' => FALSE,
        ],
		'big-square' => [
            'uploadDir' => 'big-square/',
            'width' => 350,
            'height' => 350,
			'locationMode' => 0,// Thumbnailer::THUMBNAIL_LOCATION_CENTER,
			'typeMode' => 2, //Thumbnailer::THUMBNAIL_TYPE_AUTO_SIZE,
            'quality' => 100,
			'isDefault' => FALSE,
        ],
		'big' => [
            'uploadDir' => 'big/',
            'width' => 530,
            'height' => FALSE,
			'locationMode' => 1,// Thumbnailer::THUMBNAIL_LOCATION_CENTER,
			'typeMode' => 1, //Thumbnailer::THUMBNAIL_TYPE_AUTO_SIZE,
            'quality' => 100,
			'isDefault' => FALSE,
        ],
		'middle-vertical' => [
            'uploadDir' => 'middle-vertical/',
            'width' => FALSE,
            'height' => 300,
			'locationMode' => 1, //Thumbnailer::THUMBNAIL_LOCATION_CENTER,
			'typeMode' => 1, //THUMBNAIL_TYPE_STRICT_SIZE
            'quality' => 100,
			'isDefault' => FALSE,
        ],
		'middle' => [
            'uploadDir' => 'middle/',
            'width' => 400,
            'height' => FALSE,
			'locationMode' => 1, //Thumbnailer::THUMBNAIL_LOCATION_CENTER,
			'typeMode' => 1, //Thumbnailer::THUMBNAIL_TYPE_AUTO_SIZE,
            'quality' => 100,
			'isDefault' => FALSE,
        ],
		'sert' => [
            'uploadDir' => 'sert/',
            'width' => 500,
            'height' => 300,
			'locationMode' => 0, //Thumbnailer::THUMBNAIL_LOCATION_CENTER,
			'typeMode' => 2, //THUMBNAIL_TYPE_STRICT_SIZE
            'quality' => 100,
			'isDefault' => FALSE,
        ],
		'middle-square' => [
            'uploadDir' => 'middle-square/',
            'width' => 230,
            'height' => 230,
			'locationMode' => 0, //Thumbnailer::THUMBNAIL_LOCATION_CENTER,
			'typeMode' => 2, //THUMBNAIL_TYPE_STRICT_SIZE
            'quality' => 100,
			'isDefault' => FALSE,
        ],
		'mini' => [
            'uploadDir' => 'mini/',
            'width' => 200,
            'height' => FALSE,
			'locationMode' => 1, //Thumbnailer::THUMBNAIL_LOCATION_CENTER,
			'typeMode' => 1, //Thumbnailer::THUMBNAIL_TYPE_AUTO_SIZE,
            'quality' => 100,
			'isDefault' => FALSE,
        ],
		'icon' => [
            'uploadDir' => 'icon/',
            'width' => FALSE,
            'height' => 30,
			'locationMode' => 1, //Thumbnailer::THUMBNAIL_LOCATION_CENTER,
			'typeMode' => 1, //Thumbnailer::THUMBNAIL_TYPE_AUTO_SIZE,
            'quality' => 100,
			'isDefault' => FALSE,
        ],
		'thumbgall' => [
            'uploadDir' => 'thumbgall/',
            'width' => FALSE,
            'height' => 100,
			'locationMode' => 1, //Thumbnailer::THUMBNAIL_LOCATION_CENTER,
			'typeMode' => 1, //Thumbnailer::THUMBNAIL_TYPE_AUTO_SIZE,
            'quality' => 100,
			'isDefault' => FALSE,
        ],
        'thumbnail' => [
            'uploadDir' => 'thumbnail/',
            'width' => 100,
            'height' => FALSE,
			'locationMode' => 1, //Thumbnailer::THUMBNAIL_LOCATION_CENTER,
			'typeMode' => 1, //Thumbnailer::THUMBNAIL_TYPE_AUTO_SIZE,
            'quality' => 100,
			'isDefault' => TRUE,
        ],
    ],
    'paths' => [
		'downloadDir' => '/files/',
        'uploadDir' => '@webroot/files/',
		'nophotoDir' => 'nophoto/',
		'nophotoFilename' => 'no_photo.jpg',
    ],
];