<?php
use app\components\widgets\MenuTreeItems;

$currentUrl = explode('/', Yii::$app->getRequest()->getPathInfo());
?>
<?php if ($menu): ?>
	<?= MenuTreeItems::widget([
		'data' => $menu,
		'currentUrl' => $currentUrl[0], // current url
		'isFull' => false, // если false в корневом элементе меню выводяться только элементы "li" без "ul" (бывает необходимо в связи с особеностями верстки шаблона)
		'activeClass' => 'active', // css класс активного элемента
		'ulParentClass' => null, // css класс родительского элемента ul(списка)
		'ulChildClass' => null, // css класс дочернего элемента ul(списка)
		'liParentClass' => null, // css класс родительского элемента li(списка)
		'liChildClass' => null, // css класс дочернего элемента li(списка)
		'aParentClass' => null, // css класс родительского элемента a(ссылки)
		'aChildClass' => null, // css класс дочернего элемента a(ссылки)
	]); ?>
<?php endif; ?>