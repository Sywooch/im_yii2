<?php
use yii\helpers\Html;
use app\modules\action\Module;
use app\modules\file\components\Img;
use app\components\helpers\Text;

use app\components\widgets\Breadcrumbs;

$this->params['breadcrumbs'][] = $this->params['title_h1'];
$this->params['page_class'] = 'page-action';
?>
<section class="cont">
	<?= Breadcrumbs::widget([
		'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
	]) ?>
	<h1 class="h-main"><?= Html::encode($this->params['title_h1']) ?></h1>
	
	<?php if ($mainAction): ?>
		<article class="article">
			<?= $mainAction->body ?>
		</article>
	<?php endif; ?>
</section>

<section class="program program_light">
	<?php if ($actions): ?>
		<div id="listView" class="cont program__flex">
			<?php foreach($actions as $item): ?>
				<div class="program__item">
					<?= Text::_edit($item->id, 'action') ?> <!-- Ссылка на редактирование материала -->
					<a href="/actions/<?= $item->alias ?>" class="convex">
						<div class="convex__gor">
							<div class="convex__vert">
								<?php if($item->thumb):?>
									<img src="<?= Img::_(Module::getInstance()->imagesDirectory, $item->id, 'middle-square', $item->thumb->filename) ?>"> <!-- 230X230 -->
								<?php endif; ?>
							</div>
						</div>
					</a>
					<div class="program__content">
						<h3 class="program__header"><a href="/actions/<?= $item->alias ?>"><?= $item->short_title ?></a></h3>
						<div class="program__date"><?= Text::_date($item->date, '.', ' ', ' года')?></div>
						<div class="program__text">
							<?= $item->teaser ?>
						</div>
					</div>
					<a class="button" onclick="addOrderAction(<?= $item->id ?>, '<?= htmlspecialchars($item->short_title) ?>');">Участвовать в акции</a>
				</div>
			<?php endforeach; ?>
		</div>	
	<?php else: ?>
		<h2>Извините, в этом разделе пока нет материалов.</h2>
	<?php endif; ?>
	
	<?php if ($dataProvider->totalCount > $dataProvider->pagination->pageSize): ?>
		<a href="#" id="showMore" class="button-more">Показать еще <img src="/img/loader.gif" alt="" class="loading" style="display:none;"></a>
		<script type="text/javascript">
		/*<![CDATA[*/
			(function($)
			{
				// запоминаем текущую страницу и их максимальное количество
				var page = parseInt('<?php echo (int)Yii::$app->request->getQueryParam('page', 1); ?>');
				var pageCount = parseInt('<?php echo (int)$dataProvider->pagination->pageCount; ?>');
	 
				var loadingFlag = false;
	 
				$('#showMore').click(function()
				{
					// защита от повторных нажатий
					if (!loadingFlag)
					{
						// выставляем блокировку
						loadingFlag = true;
						
						page = page + 1;
						
						// отображаем анимацию загрузки
						$('.loading').show();
	 
						$.ajax({
							type: 'post',
							url: window.location.href,
							data: {
								// передаём номер нужной страницы методом POST
								'page': page
							},
							success: function(data)
							{
								// увеличиваем номер текущей страницы и снимаем блокировку
								//page++;                            
								loadingFlag = false;                            
	 
								// прячем анимацию загрузки
								$('.loading').hide();
	 
								// вставляем полученные записи после имеющихся в наш блок
								$('#listView').append(data);
	 
								// если достигли максимальной страницы, то прячем кнопку
								if (page >= pageCount){
									$('#showMore').hide();
								}
							}
						});
					}
					return false;
				})
			})(jQuery);
		/*]]>*/
		</script>
	<?php endif; ?>
</section>