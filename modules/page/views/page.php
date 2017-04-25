<?php
use yii\helpers\Html;
use app\components\helpers\Text;
use app\components\widgets\Breadcrumbs;
use app\modules\main\components\BlockForm;
use app\modules\catalog\components\BlockCatalog;

$this->params['breadcrumbs'][] = $page->title;
$this->params['page_class'] = 'page-action';
?>
<div class="shop-area ptb-10">
	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-3">
				<!-- home-two-menu -->
				<?= BlockCatalog::left() ?>
				<div id="recently_block" class="ptb-30"></div>
			</div>
			<!-- Right section Strat -->
			<div class="col-lg-9 col-md-9">
				<?= Breadcrumbs::widget([
					'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
				]) ?>
				
				<h1><?= Html::encode($page->title) ?></h1>
				
				<?php if ($page->alias == 'contacts'): ?>
					<div class="map">
						<?= $this->params['siteinfo']->map ?>
					</div>

					<div class="cont cont-cards">
						<div class="cont-cards__item">
							<table class="contacts-table">
								<tr>
									<td><img src="/img/map.png" alt=""></td>
									<td><?= $this->params['siteinfo']->address ?></td>
								</tr>
								<tr>
									<td><img src="/img/tel.png" alt=""></td>
									<td><a href="tel:<?= $this->params['siteinfo']->phone ?>"><?= $this->params['siteinfo']->phone ?></a></td>
								</tr>
								<tr>
									<td><img src="/img/calendar.png" alt=""></td>
									<td>Ежедневно с 10:00 до 21:00</td>
								</tr>
								<tr>
									<td><img src="/img/mail.png" alt=""></td>
									<td><a href="mailto:<?= $this->params['siteinfo']->email ?>"><?= $this->params['siteinfo']->email ?></a></td>
								</tr>
							</table>
						</div>
						<div class="cont-cards__item">
							<?= BlockForm::_contact() ?>
						</div>
					</div>
				<?php endif; ?>

				<?= Text::_edit($page->id, 'page') ?> <!-- Ссылка на редактирование материала -->
				<article class="article">
					<?= $page->body ?>
				</article>
			</div>
		</div>
	</div>
</div>