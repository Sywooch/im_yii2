<?php
namespace app\modules\file\components;

use Yii;
use yii\web\UploadedFile;
use app\modules\file\components\Thumbnailer;
use yii\helpers\FileHelper;
use app\modules\file\models\File;

class Image
{
	public static function load($moduleImageDir, $contentId, $model, $filename, $ext = 'jpg')
	{
		$thumbnailer = new Thumbnailer();
		
		$ext = strtolower($ext);
		$outputFormat = $ext;
		
		if($ext == 'jpg') $outputFormat = 'jpeg';

		if($ext == 'ico')
		{
			$model->saveAs(Yii::getAlias('@webroot/'.$filename.'.'.$ext));
		}
		else
		{
			$imagesPath = Yii::$app->params['images']['paths']['uploadDir'];
			$imagesVersion = Yii::$app->params['images']['versions'];

			FileHelper::createDirectory(Yii::getAlias($imagesPath . $moduleImageDir . '/' . $contentId . '/'));
			$model->saveAs(Yii::getAlias($imagesPath . $moduleImageDir . '/' . $contentId . '/' . $filename . '.' . $ext));

			foreach ($imagesVersion as $version => $value) {
				if ($value['isDefault']) {
					FileHelper::createDirectory(Yii::getAlias($imagesPath . $moduleImageDir . '/' . $contentId . '/' . $value['uploadDir']));
					$thumbnailer->makeThumbnail(Yii::getAlias($imagesPath . $moduleImageDir . '/' . $contentId . '/' . $filename . '.' . $ext), Yii::getAlias($imagesPath . $moduleImageDir . '/' . $contentId . '/' . $value['uploadDir'] . $filename . '.' . $ext), $value['typeMode'], $value['width'], $value['height'], $value['locationMode'], $value['quality'], '#FFF', $outputFormat);
				}
			}
		}
	}
	
	public static function deleteAsPost($postRequest = false)
	{
		$return = false;
		
		if ($postRequest)
		{
			$imagesPath = Yii::$app->params['images']['paths']['uploadDir'];
			$imagesVersion = Yii::$app->params['images']['versions'];
			
			$success = is_file(Yii::getAlias($imagesPath.$postRequest['imagesDirectory'].'/'.$postRequest['contentId'].'/'.$postRequest['fileName'])) && unlink(Yii::getAlias($imagesPath.$postRequest['imagesDirectory'].'/'.$postRequest['contentId'].'/'.$postRequest['fileName']));
			if ($success) {
				foreach ($imagesVersion as $version => $value) {
					
					if (is_file(Yii::getAlias($imagesPath.$postRequest['imagesDirectory'].'/'.$postRequest['contentId'].'/'.$value['uploadDir'].$postRequest['fileName']))) {
						unlink(Yii::getAlias($imagesPath.$postRequest['imagesDirectory'].'/'.$postRequest['contentId'].'/'.$value['uploadDir'].$postRequest['fileName']));
					}
				}
			}
			File::findOne($postRequest['fileId'])->delete();
			$return = true;
        } 
		return $return;
	}
	
	public static function delete($moduleImageDir = '', $contentId = 0, $fileName = '', $fileId = 0)
	{
		$return = false;
		
		$imagesPath = Yii::$app->params['images']['paths']['uploadDir'];
		$imagesVersion = Yii::$app->params['images']['versions'];

		if($fileName == 'favicon.ico')
		{
			is_file(Yii::getAlias('@webroot/'.$fileName)) && unlink(Yii::getAlias('@webroot/'.$fileName));
		}
		else
		{
			$success = is_file(Yii::getAlias($imagesPath.$moduleImageDir.'/'.$contentId.'/'.$fileName)) && unlink(Yii::getAlias($imagesPath.$moduleImageDir.'/'.$contentId.'/'.$fileName));
			if ($success)
			{
				foreach ($imagesVersion as $version => $value)
				{
					if (is_file(Yii::getAlias($imagesPath.$moduleImageDir.'/'.$contentId.'/'.$value['uploadDir'].$fileName)))
					{
						unlink(Yii::getAlias($imagesPath.$moduleImageDir.'/'.$contentId.'/'.$value['uploadDir'].$fileName));
					}
				}
			}
		}

		File::findOne($fileId)->delete();
		$return = true;
		return $return;
	}
}