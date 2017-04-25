<?php
namespace app\modules\company\components;

use Yii;
use app\modules\company\models\Company;

class BlockCompany
{
	public static function front($titleBlock = 'Организации')
	{
		$companies = Company::find()->where(['account_type' => 0])->all();
		return Yii::$app->view->renderFile('@app/modules/company/views/company-block-front.php', ['titleBlock' => $titleBlock, 'companies' => $companies]);
	}
}