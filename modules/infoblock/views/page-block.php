<?php

use yii\helpers\Html;
use app\components\helpers\Text;
?>
<?php if ($block && !empty($block->body)): ?>
	<div style="position:relative">
		<?= Text::_edit($block->id, 'infoblock') ?> <!-- Ссылка на редактирование материала -->
		<?= $block->body ?>	
	</div>
<?php endif; ?>