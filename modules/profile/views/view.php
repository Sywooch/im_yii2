<?php

use yii\helpers\Html;
use app\modules\file\components\Img;
use app\modules\profile\Module;

?>
<div class="divider"></div>
<!-- Section -->
<section class="section">

	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6">
			<?php if($profile->thumb):?>
				<img src="<?= Img::_('profile', $profile->id, 'large', $profile->thumb->filename) ?>" alt="">
			<?php endif; ?>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6">
			<h2><?= Html::encode($profile->lastname .' '. $profile->name .' '. $profile->phathername .' '. $profile->age . ' лет') ?></h2>
			
			<div class="divider"></div>
			
		</div>
	</div><!-- /Row -->
</section>
<!-- /Section -->
