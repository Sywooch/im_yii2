<?php

namespace app\modules\file\models;

use Yii;
use yii\helpers\FileHelper;
use app\components\helpers\Text;
use yii\web\UploadedFile;
use app\modules\file\components\Image;

/**
 * This is the model class for table "{{%file}}".
 *
 * @property integer $id
 * @property integer $content_id
 * @property string $module
 * @property string $filename
 * @property string $type
 * @property string $delta
 */
class File extends \yii\db\ActiveRecord
{
    /**
     * TABLE NAME
     */
    public static function tableName()
    {
        return '{{%file}}';
    }

    /**
     * RULES
     */
    public function rules()
    {
        return [
			[['content_id', 'type', 'delta'], 'integer'],
			[['filename'], 'file', 'extensions' => ['png', 'jpg', 'gif'], 'maxSize' => 1024*1024],
			[['type'], 'default', 'value' => 1],
			[['delta'], 'default', 'value' => 0],
        ];
    }

	/*** Редактирование (добавление) картинки миниатюры для связанных таблиц БД ***/
	public function updateThumb($post, $model, $id = 0, $module = '', $imageDirectory = false)
	{
		if($model->imageFile = UploadedFile::getInstance($model, 'imageFile'))
		{
			/*************** Транслитерация имени файла ******************/
			$newname = Text::transliterate($model->imageFile->baseName);

			if(!$imageDirectory)
			{
				$imageDirectory = $module;
			}
			
			if($model->thumb)
			{
				Image::delete($imageDirectory, $id, $model->thumb->filename, $model->thumb->id);
			}

			Image::load($imageDirectory, $id, $model->imageFile, $newname, $model->imageFile->extension);

			$fileModel = new File();
			$fileModel->filename = $newname.'.'.$model->imageFile->extension;
			$fileModel->content_id = $id;
			$fileModel->module = $module;
			$fileModel->type = 1;
			$fileModel->delta = 0;

			$fileModel->save();
		}
	}
	
	/*** Редактирование (добавление) картинки2 миниатюры для связанных таблиц БД ***/
	public function updateThumb2($post, $model, $id = 0, $module = '', $imageDirectory = false)
	{
		if($model->imageFile2 = UploadedFile::getInstance($model, 'imageFile2'))
		{
			/*************** Транслитерация имени файла ******************/
			$newname = Text::transliterate($model->imageFile2->baseName);

			if(!$imageDirectory)
			{
				$imageDirectory = $module;
			}
			
			if($model->thumb2)
			{
				Image::delete($imageDirectory, $id, $model->thumb2->filename, $model->thumb2->id);
			}

			Image::load($imageDirectory, $id, $model->imageFile2, $newname, $model->imageFile2->extension);

			$fileModel = new File();
			$fileModel->filename = $newname.'.'.$model->imageFile2->extension;
			$fileModel->content_id = $id;
			$fileModel->module = $module;
			$fileModel->type = 4;
			$fileModel->delta = 0;

			$fileModel->save();
		}
	}

	/*** Редактирование (добавление) Логотипа ***/
	public function updateLogo($post, $model, $id = 1, $module = 'main', $imageDirectory = false)
	{
		if($model->logoFile = UploadedFile::getInstance($model, 'logoFile'))
		{
			/*************** Транслитерация имени файла ******************/
			$newname = Text::transliterate($model->logoFile->baseName);

			if(!$imageDirectory)
			{
				$imageDirectory = $module;
			}
			
			if($model->logo)
			{
				Image::delete($imageDirectory, $id, $model->logo->filename, $model->logo->id);
			}

			Image::load($imageDirectory, $id, $model->logoFile, $newname, $model->logoFile->extension);

			$fileModel = new File();
			$fileModel->filename = $newname.'.'.$model->logoFile->extension;
			$fileModel->content_id = $id;
			$fileModel->module = $module;
			$fileModel->type = 1;
			$fileModel->delta = 0;

			$fileModel->save();
		}
	}

	/*** Редактирование (добавление) файлов для связанных таблиц БД ***/
	public function updateFiles($post, $model, $id = 0, $module = '', $imageDirectory = false)
	{
		if($model->imageGallery = UploadedFile::getInstances($model, 'imageGallery'))
		{
			if(!$imageDirectory)
			{
				$imageDirectory = $module;
			}
			
			foreach($model->imageGallery as $delta => $gallery)
			{
				/*************** Транслитерация имени файла ******************/
				$newname = Text::transliterate($gallery->baseName);

				Image::load($imageDirectory, $id, $gallery, $newname, $gallery->extension);

				$fileModel = new File();
				$fileModel->filename = $newname.'.'.$gallery->extension;
				$fileModel->content_id = $id;
				$fileModel->module = $module;
				$fileModel->type = 2;
				$fileModel->delta = $delta;

				$fileModel->save();
			}
		}
		elseif($model->files)
		{
			foreach($model->files as $item)
			{
				$fileModel = File::findOne($item->id);
				$fileModel->delta = $post['imageAttr'][$item->id]['delta'];
				$fileModel->alt = $post['imageAttr'][$item->id]['alt'];
				$fileModel->title = $post['imageAttr'][$item->id]['title'];
				$fileModel->save();
			}
		}
	}

	/*** Редактирование (добавление) Favicon ***/
	public function updateIcon($post, $model, $id = 1, $module = 'main')
	{
		if($model->iconFile = UploadedFile::getInstance($model, 'iconFile'))
		{
			if($model->icon)
			{
				Image::delete($module, $id, 'favicon.ico', $model->icon->id);
			}

			Image::load($module, $id, $model->iconFile, 'favicon', 'ico');

			$fileModel = new File();
			$fileModel->filename = 'favicon.ico';
			$fileModel->content_id = $id;
			$fileModel->module = $module;
			$fileModel->type = 3;
			$fileModel->delta = 0;

			$fileModel->save();
		}
	}
	
	/****** Удаление файлов и записей из связанных таблиц БД ********/
	public function deleteFiles($id = 0, $module = '', $imageDirectory = false)
	{
		if(!$imageDirectory)
		{
			$imageDirectory = $module;
		}
		// Удаляем записи в базе данных
		if(File::deleteAll(['module' => $module, 'content_id' => $id]))
		{
			// Удаляем все файлы материала
			FileHelper::removeDirectory(Yii::getAlias(Yii::$app->params['images']['paths']['uploadDir'].$imageDirectory.'/'.$id.'/'));
		}
	}
}
