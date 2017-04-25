<?php

use yii\helpers\Html;
use app\modules\review\Module;
use app\modules\file\components\Img;

$this->params['breadcrumbs'][] = ['label' => 'Отзывы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $review->title;
?>
<section class="cont">
	<h1 class="h h_primary">
		<span class="h__text"><?= Html::encode($review->title) ?></span>
	</h1>

	<article class="article">
		<?= $review->body ?>
	</article>
	
	<?php if($review->thumb):?>
		<img src="<?= Img::_('review', $review->id, 'middle', $review->thumb->filename) ?>" alt="" class="review__left">	<!-- 400X -->
	<?php endif; ?>
</section>