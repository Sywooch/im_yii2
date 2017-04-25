<?php

namespace app\modules\seo\models;

use Yii;

/**
 * This is the model class for table "{{%seo}}".
 *
 * @property string $id
 * @property integer $content_id
 * @property string $meta_title
 * @property string $title_h1
 * @property string $meta_key
 * @property string $meta_desc
 * @property string $meta_title2
 * @property string $title_h12
 * @property string $meta_key2
 * @property string $meta_desc2
 * @property string $module
 */
class Seo extends \yii\db\ActiveRecord
{
    /**
     * TABLE NAME
     */
    public static function tableName()
    {
        return '{{%seo}}';
    }

    /**
     * RULES
     */
    public function rules()
    {
        return [
            [['content_id', 'module'], 'required'],
            [['content_id'], 'integer'],
            [['meta_key', 'meta_desc', 'meta_key2', 'meta_desc2'], 'string'],
            [['meta_title', 'title_h1', 'meta_title2', 'title_h12', 'module'], 'string', 'max' => 255],
        ];
    }

    /**
     * LABELS
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content_id' => '',
            'meta_title' => Module::t('module', 'SEO_BACK_FORM_META_TITLE'),
			'title_h1' => Module::t('module', 'SEO_BACK_FORM_TITLE_H1'),
            'meta_key' => Module::t('module', 'SEO_BACK_FORM_META_KEY'),
            'meta_desc' => Module::t('module', 'SEO_BACK_FORM_META_DESC'),
			'meta_title2' => Module::t('module', 'SEO_BACK_FORM_META_TITLE2'),
			'title_h12' => Module::t('module', 'SEO_BACK_FORM_TITLE_H12'),
            'meta_key2' => Module::t('module', 'SEO_BACK_FORM_META_KEY2'),
            'meta_desc2' => Module::t('module', 'SEO_BACK_FORM_META_DESC2'),
            'module' => '',
        ];
    }

    /*** Редактирование (добавление) записей для связанных таблиц БД ***/
    public function updateSeo($post, $id = 0, $module = '')
    {
        if(!$seoModel = Seo::findOne(['content_id' => $id, 'module' => $module]))
        {
            $seoModel = new Seo();
        }

        $seoModel->content_id = $id;
        $seoModel->title_h1 = $post['Seo']['title_h1'];
        $seoModel->meta_title = $post['Seo']['meta_title'];
        $seoModel->meta_key = $post['Seo']['meta_key'];
        $seoModel->meta_desc = $post['Seo']['meta_desc'];
		
		if($module == 'event')
		{
			$seoModel->title_h12 = (isset($post['Seo']['title_h12']))? $post['Seo']['title_h12']:'';
			$seoModel->meta_title2 = (isset($post['Seo']['meta_title2']))? $post['Seo']['meta_title2']:'';
			$seoModel->meta_key2 = (isset($post['Seo']['meta_key2']))? $post['Seo']['meta_key2']:'';
			$seoModel->meta_desc2 = (isset($post['Seo']['meta_desc2']))? $post['Seo']['meta_desc2']:'';
		}
		
        $seoModel->module = $module;

        $seoModel->save();
    }
	
	/****** Удаление записей из связанных таблиц БД ********/
	public function deleteSeo($id = 0, $module = '')
	{
		Seo::deleteAll(['module' => $module, 'content_id' => $id]);
	}
}