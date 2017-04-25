<?php
namespace app\modules\file\components;

use yii\base\Exception;

class Thumbnailer
{
	// откуда будем резать тамб у картинки
	
	/**
	 * Если картинка вертикальная - то миниатюра будет браться сверху, если горизонтальная - слева.
	 * (Имеет смысл только при типе THUMBNAIL_TYPE_STRICT_SIZE_NO_LINES, в других случаях миниатюра
	 * всегда будет полностью видима)
	 */
	const THUMBNAIL_LOCATION_TOP_OR_LEFT = 0;
	/**
	 * Миниатюра будет взята с центра картинки
	 */
	const THUMBNAIL_LOCATION_CENTER= 1;
	/**
	 * Если картинка вертикальная - то миниатюра будет браться снизу, если горизонтальная - справа.
	 * (Имеет смысл только при типе THUMBNAIL_TYPE_STRICT_SIZE_NO_LINES, в других случаях миниатюра
	 * всегда будет полностью видима)
	 */
	const THUMBNAIL_LOCATION_BOTTOM_OR_RIGHT = 2;
	
	// как будем резать тамб

	/**
	 * Миниатюра будет строго указанного размера, если соотношения сторон исходного изображения и
	 * миниатюры не совпадают - то останутся полосы указанного цвета.
	 */
	const THUMBNAIL_TYPE_STRICT_SIZE = 0;
	/**
	 * Одна из сторон миниатюры будет строго заданного размера, а другая - меньше настолько,
	 * чтобы совпало соотношение сторон.
	 */
	const THUMBNAIL_TYPE_AUTO_SIZE = 1;
	/**
	 * Миниатюра будет строго указанного размера и на ней не будет полос, но если соотношения
	 * сторон миниатюры и исходного изображения не совпадут, то миниатюра будет содержать не всю
	 * картинку, а только её часть.
	 * (Какая часть будет содержаться в миниатюре указывается параметром Thumbnailer::THUMBNAIL_LOCATION_*)
	 */
	const THUMBNAIL_TYPE_STRICT_SIZE_NO_LINES = 2;
	
	
	const OUTPUT_JPEG = 'jpeg';
	const OUTPUT_PNG= 'png';
	const OUTPUT_GIF= 'gif';
	
	
	public function Thumbnailer() {
		// иначе на некотоых jpeg-файлах не работает
		ini_set("gd.jpeg_ignore_warning", 1);
	}
	
	protected function getSizes($path) {
		list($width, $height, $type) = getimagesize($path);
		
		$typeStr = FALSE;
		switch ($type) {
			case IMAGETYPE_JPEG: $typeStr = 'jpeg'; break;
			case IMAGETYPE_GIF: $typeStr = 'gif' ;break;
			case IMAGETYPE_PNG: $typeStr = 'png'; break;
		}
		
		if ($typeStr === FALSE) {
			throw new Exception('unsupported image type');
		}
		
		return [$width, $height, $typeStr];
	}
	
	/**
	 * Генерирует по указанным исходным значениям $sourceWidth и $sourceHeight
	 * точные значения $width и $height (может быть задано только одно из двух)
	 * на основе соотношения сторон исходного размера.
	 * @param double $sourceWidth Исходная ширина
	 * @param double $sourceHeight Исходная высота
	 * @param mixed $width Требуемая ширина или FALSE (тогда ширина будет сгенерирована по высоте)
	 * @param mixed $height Требуемая высота или FALSE (тогда высота будет сгенерирована по ширине)
	 * @return Array Точный значения ширины и высоты. Если одно из $width или $height
	 * передано как FALSE, то результат будет с учетом соотношения сторон ихсодного изображения
	 */
	protected function generateExactSize($sourceWidth, $sourceHeight, $width = FALSE, $height = FALSE) {
		if ($width === FALSE && $height === FALSE) {
			throw new Exception('width or height must have exact value');
		}
		// если точные значения переданы - то их и возвращаем
		if ($width !== FALSE && $height !== FALSE) {
			return [$width, $height];
		}
		$aspectRatio = $sourceWidth/$sourceHeight;
		// иначе вычисляем одно на основании другого
		if ($width === FALSE) {
			
			// если переданная высота больше реальной высоты - то оставляем реальные размеры
			if($height >= $sourceHeight){
				$width = $sourceWidth;
				$height = $sourceHeight;
			} else {
				$width = $aspectRatio * $height;
			}
			
		} else if ($height === FALSE) {
			
			// если переданная ширина больше реальной ширины - то оставляем реальные размеры
			if($width >= $sourceWidth){
				$width = $sourceWidth;
				$height = $sourceHeight;
			} else {
				$height = $width/$aspectRatio;
			}
		}
		
		return [$width, $height];
	}
	
	/**
	 * По ширине и высоте возвращает максимальный размер прямоугольника который
	 * можно вписать в исходный прямоугольник с учетом указанного соотношения сторон
	 * @param double $sourceWidth Ширина
	 * @param double $sourceHeight Высота
	 * @param double $aspectRatio Соотношение сторон
	 * @return Array Ширина и высота максимально большого вписанного прямоугольника
	 */
	protected function fitRectangle($sourceWidth, $sourceHeight, $aspectRatio) {
		$height = $sourceHeight;
		$width = $height * $aspectRatio;
		
		if ($width > $sourceWidth) {
			$width = $sourceWidth;
			$height = $width / $aspectRatio;
		}
		
		return [$width, $height];
	}
	
	/**
	 * По ширине и высоте возвращает максимальный размер прямоугольника который
	 * можно описать около исходного прямоугольника с учетом указанного соотношения сторон
	 * @param double $sourceWidth Ширина
	 * @param double $sourceHeight Высота
	 * @param double $aspectRatio Соотношение сторон
	 * @return Array Ширина и высота максимально большого вписанного прямоугольника
	 */
	protected function circumscribeRectangle($sourceWidth, $sourceHeight, $aspectRatio) {
		$height = $sourceHeight;
		$width = $height * $aspectRatio;
		
		if ($width < $sourceWidth) {
			$width = $sourceWidth;
			$height = $width / $aspectRatio;
		}
		
		return [$width, $height];
	}
	
	/**
	 * По шестнадцатиричному представлению цвета генерирует цвет по RGB каналам
	 * от 0 до 255
	 * @param string $hexStr цвет в шестнадцатиричном представлении. Варианты: FFFFFF, #FFFFFF, FFF, #FFF
	 * @return Array Массив содержащий три компоненты цвета: R, G и B
	 */
	protected function hexColor2rgb($hexStr) {
		$hex = str_replace("#", "", $hexStr);

		if(strlen($hex) == 3) {
			$r = hexdec(substr($hex,0,1).substr($hex,0,1));
			$g = hexdec(substr($hex,1,1).substr($hex,1,1));
			$b = hexdec(substr($hex,2,1).substr($hex,2,1));
		} else {
			$r = hexdec(substr($hex,0,2));
			$g = hexdec(substr($hex,2,2));
			$b = hexdec(substr($hex,4,2));
		}
		return [$r, $g, $b];
	}
	
	/**
	 * По исходному файлу, который расположен в $sourcePath (не url!) к изображению
	 * генерирует миниатюру и сохраняет ее в файл $destinationPath
	 * @param string $sourcePath Путь к изображению. доступны форматы jpg, gif, png
	 * @param string $destinationPath Файл, в который в случае успеха будет сохранен результат
	 * @param int $thumbnailType Одна из констант текущего класса Thumbnailer::THUMBNAIL_TYPE_*
	 * @param mixed $width Необходимая ширина миниатюры или FALSE (тогда будет автоматически получена по $heigh и соотношению сторон исходного изображения)
	 * @param mixed $height Необходимая высота миниатюры или FALSE (тогда будет автоматически получена по $width и соотношению сторон исходного изображения)
	 * @param int $thumbnailLocation Одна из констант текущего класса Thumbnailer::THUMBNAIL_LOCATION_*
	 * @param int $quality значение от 0 до 100 обозначающее качество сохраняемого jpg файла (100 - максимальное сжатие), для Thumbnailer::OUTPUT_GIF не имеет значения
	 * @param string $lineColor Если в $thumbnailType = Thumbnailer::THUMBNAIL_TYPE_STRICT_SIZE,
	 * то получившиеся полосы будут указанного цвета. Может иметь значение transparent для прозрачного фона или для цветов формат: #FFFFFF, FFFFFF, #FFF, FFF
	 * @param $outputFormat Одна из констант Thumbnailer::OUTPUT_*
	 */
	function makeThumbnail($sourcePath, $destinationPath, $thumbnailType, $width=FALSE, $height=FALSE, $thumbnailLocation = self::THUMBNAIL_LOCATION_CENTER, $quality = 100, $lineColor = 'transparent', $outputFormat = self::OUTPUT_JPEG) {
		if ($width === FALSE && $height === FALSE) {
			throw new Exception('width or height must have exact value');
		}
		
		if (!is_file($sourcePath)) {
			throw new Exception('file: "'.$sourcePath.'" doesn\'t exist');
		}
		
		if (array_search($thumbnailLocation, [self::THUMBNAIL_LOCATION_TOP_OR_LEFT, self::THUMBNAIL_LOCATION_CENTER, self::THUMBNAIL_LOCATION_BOTTOM_OR_RIGHT]) === FALSE) {
			throw new Exception('incorrect thumbnail location param: "'.$thumbnailLocation.'"');
		}
		
		if (array_search($thumbnailType, [self::THUMBNAIL_TYPE_AUTO_SIZE, self::THUMBNAIL_TYPE_STRICT_SIZE, self::THUMBNAIL_TYPE_STRICT_SIZE_NO_LINES]) === FALSE) {
			throw new Exception('incorrect thumbnail type param: "'.$thumbnailType.'"');
		}
		
		if (array_search($outputFormat, [self::OUTPUT_GIF, self::OUTPUT_JPEG, self::OUTPUT_PNG]) === FALSE) {
			throw new Exception('incorrect output format param: "'.$outputFormat.'"');
		}
		
		// получаем параметры исходного изображения
		list($sourceWidth, $sourceHeight, $sourceType) = $this->getSizes($sourcePath);
		// если не заданы точная ширина или высота, то генерим её
		if ($width === FALSE || $height === FALSE) {
			list($width, $height) = $this->generateExactSize($sourceWidth, $sourceHeight, $width, $height);
		}
		// вычисляем максимальные размеры вписанного прямоугольника в исходное изображение
		list($fitWidth, $fitHeight) = $this->fitRectangle($sourceWidth, $sourceHeight, $width/$height);
		// вычисляем максимальные размеры вписанного прямоугольника в исходное изображение
		list($circumscribeWidth, $circumscribeHeight) = $this->circumscribeRectangle($sourceWidth, $sourceHeight, $width/$height);
		
		// теперь вычисляем размеры маленького тамба вписанного и описанного в начальное изображение:
		list($thumbFitWidth, $thumbFitHeight) = $this->fitRectangle($width, $height, $sourceWidth/$sourceHeight);
		list($thumbCircumscribeWidth, $thumbCircumscribeHeight) = $this->circumscribeRectangle($width, $height, $sourceWidth/$sourceHeight);

		$function = 'imagecreatefrom'.$sourceType;
		$sourceImg = $function($sourcePath);
		if ($sourceImg === FALSE) {
			throw new Exception('unable to load source image');
		}
		
		$resultingThumbWidth = 0;
		$resultingThumbHeight = 0;
		if ($thumbnailType === self::THUMBNAIL_TYPE_STRICT_SIZE) {
			// то есть тамб с полосами ( = описанный прямоугольник)
			$resultingThumbWidth = $width;
			$resultingThumbHeight = $height;
		} else if ($thumbnailType === self::THUMBNAIL_TYPE_STRICT_SIZE_NO_LINES) {
			// тамб без полос
			$resultingThumbWidth = $width;
			$resultingThumbHeight = $height;
		} else if ($thumbnailType === self::THUMBNAIL_TYPE_AUTO_SIZE) {
			// тамб, у которого одна сторона точно равна заданной, а вторая меньше
			$resultingThumbWidth = $thumbFitWidth;
			$resultingThumbHeight = $thumbFitHeight;
		} else {
			throw new Exception('unsupported thumbnail type: '.$thumbnailType);
		}
		
		// делаем фон у изображения заданного цвета
		$resultImg = imagecreatetruecolor($resultingThumbWidth, $resultingThumbHeight);
		
		// Если картинка в формате "png" оставляем прозрачность не зависимо от настроек lineColor
		if ($outputFormat == self::OUTPUT_PNG) {
	
			// Выключение альфа сопряжения и установка альфа флага
			imagealphablending($resultImg, false);
			imagesavealpha($resultImg, TRUE);
			
		} else {
			
			if ($lineColor != 'transparent') {
				$colorRGB = $this->hexColor2rgb($lineColor);
				$backgroundColor = imagecolorallocate($resultImg, $colorRGB[0], $colorRGB[1], $colorRGB[2]);
				imagefill($resultImg, 0, 0, $backgroundColor);
			} else {
				// Выключение альфа сопряжения и установка альфа флага
				imagealphablending($resultImg, false);
				imagesavealpha($resultImg, TRUE);
			}
		}
		
		
		// вычисляем всякое для ресамплинга в нужный размер
		$offsetSourceX = 0;
		$offsetSourceY = 0;
		$offsetX = 0;
		$offsetY = 0;
		
		$isResampledSuccess = FALSE;
		// если в центр
		if ($thumbnailLocation === self::THUMBNAIL_LOCATION_CENTER) {
			// если строго заданного размера с линиями, то 
			if ($thumbnailType === self::THUMBNAIL_TYPE_STRICT_SIZE) {
				if ($circumscribeWidth > $sourceWidth) {
					$offsetX = abs(($width - $thumbFitWidth)/2);
				} else {
					$offsetY = abs(($height - $thumbFitHeight)/2);
				}
				$isResampledSuccess = imagecopyresampled($resultImg, $sourceImg, $offsetX, $offsetY, $offsetSourceX, $offsetSourceY, $thumbFitWidth, $thumbFitHeight, $sourceWidth, $sourceHeight);
			}
			// строго заданный размер без линий (обрубаем куски исходного изображения
			else if ($thumbnailType === self::THUMBNAIL_TYPE_STRICT_SIZE_NO_LINES) {
				if ($fitWidth < $sourceWidth) {
					$offsetSourceX = abs(($sourceWidth - $fitWidth)/2);
				} else {
					$offsetSourceY = abs(($sourceHeight - $fitHeight)/2);
				}
				$isResampledSuccess = imagecopyresampled($resultImg, $sourceImg, $offsetX, $offsetY, $offsetSourceX, $offsetSourceY, $width, $height, $fitWidth, $fitHeight);
			}
			// одна сторона тамба совпадет, а другая - меньше настолько чтоб уложиться в соотношение сторон исходной картинки
			else if ($thumbnailType === self::THUMBNAIL_TYPE_AUTO_SIZE) {
				if ($fitWidth > $sourceWidth) {
					$offsetSourceX = abs(($width - $thumbFitWidth)/2);
				} else {
					$offsetSourceY = abs(($height - $thumbFitHeight)/2);
				}
				$isResampledSuccess = imagecopyresampled($resultImg, $sourceImg, $offsetX, $offsetY, $offsetSourceX, $offsetSourceY, $thumbFitWidth, $thumbFitHeight, $sourceWidth, $sourceHeight);
			}
		}
		// если слева или сверху от оригинала хотим тамб
		if ($thumbnailLocation === self::THUMBNAIL_LOCATION_TOP_OR_LEFT) {
			// строго заданный размер без линий (обрубаем куски исходного изображения
			if ($thumbnailType === self::THUMBNAIL_TYPE_STRICT_SIZE_NO_LINES) {
				if ($fitWidth > $sourceWidth) {
					$offsetSourceX = 0;
				} else {
					$offsetSourceY = 0;
				}
				$isResampledSuccess = imagecopyresampled($resultImg, $sourceImg, $offsetX, $offsetY, $offsetSourceX, $offsetSourceY, $width, $height, $fitWidth, $fitHeight);
			}
			// в других случаях тамб не обрезается => всё как обычно
			// если строго заданного размера с линиями, то 
			if ($thumbnailType === self::THUMBNAIL_TYPE_STRICT_SIZE) {
				if ($circumscribeWidth > $sourceWidth) {
					$offsetX = abs(($width - $thumbFitWidth)/2);
				} else {
					$offsetY = abs(($height - $thumbFitHeight)/2);
				}
				$isResampledSuccess = imagecopyresampled($resultImg, $sourceImg, $offsetX, $offsetY, $offsetSourceX, $offsetSourceY, $thumbFitWidth, $thumbFitHeight, $sourceWidth, $sourceHeight);
			}
			// одна сторона тамба совпадет, а другая - меньше настолько чтоб уложиться в соотношение сторон исходной картинки
			else if ($thumbnailType === self::THUMBNAIL_TYPE_AUTO_SIZE) {
				if ($fitWidth > $sourceWidth) {
					$offsetSourceX = abs(($width - $thumbFitWidth)/2);
				} else {
					$offsetSourceY = abs(($height - $thumbFitHeight)/2);
				}
				$isResampledSuccess = imagecopyresampled($resultImg, $sourceImg, $offsetX, $offsetY, $offsetSourceX, $offsetSourceY, $thumbFitWidth, $thumbFitHeight, $sourceWidth, $sourceHeight);
			}
		}

		// если справа или снизу от оригинала хотим тамб
		if ($thumbnailLocation === self::THUMBNAIL_LOCATION_BOTTOM_OR_RIGHT) {
			// строго заданный размер без линий (обрубаем куски исходного изображения
			if ($thumbnailType === self::THUMBNAIL_TYPE_STRICT_SIZE_NO_LINES) {
				if ($fitWidth < $sourceWidth) {
					$offsetSourceX = abs($sourceWidth - $fitWidth);
				} else {
					$offsetSourceY = abs($sourceHeight - $fitHeight);
				}
				$isResampledSuccess = imagecopyresampled($resultImg, $sourceImg, $offsetX, $offsetY, $offsetSourceX, $offsetSourceY, $width, $height, $fitWidth, $fitHeight);
			}
			// в других случаях тамб не обрезается => всё как обычно
			// если строго заданного размера с линиями, то 
			if ($thumbnailType === self::THUMBNAIL_TYPE_STRICT_SIZE) {
				if ($circumscribeWidth > $sourceWidth) {
					$offsetX = abs(($width - $thumbFitWidth)/2);
				} else {
					$offsetY = abs(($height - $thumbFitHeight)/2);
				}
				$isResampledSuccess = imagecopyresampled($resultImg, $sourceImg, $offsetX, $offsetY, $offsetSourceX, $offsetSourceY, $thumbFitWidth, $thumbFitHeight, $sourceWidth, $sourceHeight);
			}
			// одна сторона тамба совпадет, а другая - меньше настолько чтоб уложиться в соотношение сторон исходной картинки
			else if ($thumbnailType === self::THUMBNAIL_TYPE_AUTO_SIZE) {
				if ($fitWidth > $sourceWidth) {
					$offsetSourceX = abs(($width - $thumbFitWidth)/2);
				} else {
					$offsetSourceY = abs(($height - $thumbFitHeight)/2);
				}
				$isResampledSuccess = imagecopyresampled($resultImg, $sourceImg, $offsetX, $offsetY, $offsetSourceX, $offsetSourceY, $thumbFitWidth, $thumbFitHeight, $sourceWidth, $sourceHeight);
			}
		}
		if (!$isResampledSuccess) {
			throw new Exception('Unable to resample image');
		}
		
		// у png параметр quality принимает значение от 0 до 9, причем лучшее качество
		// когда quality = 0, поэтому переводим в шкалу от 0 до 100 где 100 - лучшее качество
		if ($outputFormat == self::OUTPUT_PNG) {
			$quality = round((100 - $quality) * 0.09);
		}
		
		$function = 'image'.$outputFormat;
		
		// и, собственно, финально копируем само изображение
		$isSaved = FALSE;
		if ($function != 'imagegif') {
			$isSaved = $function($resultImg, $destinationPath, $quality);
		} else {
			$isSaved = $function($resultImg, $destinationPath);
		}
		if (!$isSaved) {
			throw new Exception('Unable to save resulting image');
		}
		// освобождаем память
		$isDestroyed = imagedestroy($resultImg);
		if (!$isDestroyed) {
			throw new Exception('Unable to clear resource');
		}
		$isDestroyed = imagedestroy($sourceImg);
		if (!$isDestroyed) {
			throw new Exception('Unable to clear resource');
		}
		
		return TRUE;
	}
}