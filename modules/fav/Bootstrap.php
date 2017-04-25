<?php
namespace app\modules\fav;

use yii\base\BootstrapInterface;
use yii;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        yii::$container->set('app\modules\fav\interfaces\Fav', 'app\modules\fav\models\Fav');
        yii::$container->set('app\modules\fav\interfaces\Element', 'app\modules\fav\models\FavElement');
        yii::$container->set('favElement', 'app\modules\fav\models\FavElement');

        if (!isset($app->i18n->translations['fav']) && !isset($app->i18n->translations['fav*'])) {
            $app->i18n->translations['fav'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'basePath' => __DIR__.'/messages',
                'forceTranslation' => true
            ];
        }
    }
}