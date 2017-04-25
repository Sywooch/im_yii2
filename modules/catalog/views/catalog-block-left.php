<?php
use app\components\widgets\CatalogMenuTreeItems;
?>
<?php if ($catalog): ?>
	<div class="verticalmenu-container">
		<span class="megamenu-title megamenu-title3">Каталог</span>
		<div class="vmegamenu" style="display: block;">
			<?= CatalogMenuTreeItems::widget([
				'data' => $catalog,
				'url' => '/cat', // Начальный url дерева
				'ulParentClass' => null, // css класс родительского элемента ul(списка)
				'ulChildClass' => 'mega-menu mega-menu-w', // css класс дочернего элемента ul(списка)
				'liParentClass' => null, // css класс родительского элемента li(списка)
				'liChildClass' => null, // css класс дочернего элемента li(списка)
				'aParentClass' => 'mega-arrow', // css класс родительского элемента a(ссылки)
				'aChildClass' => null, // css класс дочернего элемента a(ссылки)
				'isMany' => true, // true - если виджет используется в модуле catalog, false - если в модуле menu (обусловленно особенностью данной разработки)
			]); ?>
		</div>
	</div>
<?php endif; ?>