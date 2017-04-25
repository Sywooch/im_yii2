<?php

namespace app\modules\search\components;

use Yii;
use app\modules\search\models\forms\FormSearch;

class BlockForm
{
	public static function _search($class = '')
	{
		$q = Yii::$app->request->get('q', '');
		$model = new FormSearch();
		return Yii::$app->view->renderFile('@app/modules/search/views/block-form-search.php', ['model' => $model, 'class' => $class, 'q' => $q]);
	}
}