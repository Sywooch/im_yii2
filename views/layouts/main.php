<?php

use yii\helpers\Html;
use yii\helpers\Url;

use app\assets\AppAsset;
use app\assets\EditAppAsset;

use app\components\widgets\Alert;

use app\modules\menu\components\BlockMenu;
use app\modules\main\components\BlockForm;

use app\modules\user\components\BlockLogin;
use app\modules\infoblock\components\BlockText;

use pistol88\cart\widgets\CartInformer;
use app\modules\fav\widgets\FavInformer;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="description" content="<?= $this->params['meta_description'] ?>">
	<meta name="keywords" content="<?= $this->params['meta_keywords'] ?>">

	<?= Html::csrfMetaTags() ?>
	<title><?= Html::encode($this->title) ?></title>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="apple-touch-icon" href="/apple-touch-icon.png">
	<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">

	<?php $this->head() ?>
</head>
<body class="<?= $this->params['page_class'] ?>">

	<?php $this->beginBody() ?>
	
	<!--[if lt IE 10]>
		<p class="browsehappy">Вы используете <strong>устаревший</strong> браузер. Пожалуйста <a href="http://browsehappy.com/">обновите ваш браузер</a> для улучшения отображения сайта.</p>
	<![endif]-->
	
	<?= $this->params['siteinfo']->counter ?>
	
	<div class="home6">
		<div class="body-wrapper">
		
			<!--header-->
			<header class="header-area">
				<div class="header-top-area header-top-area6">
					<div class="container">
						<div class="row">
							<div class="col-md-6">
								<div class="phone">
									<?= $this->params['siteinfo']->phone ?>
									<a href="#recall" class="recall-button fancybox">Заказать звонок</a>
								</div>
							</div>
							<div class="col-md-4">
								<div class="search-block search-block3">
									<div class="search-block-content">
										<?= \app\modules\search\components\BlockForm::_search() ?>
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="top-link-dropdown top-link-dropdown3">
									<div class="toggle-action">
										<?= BlockLogin::_() ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--/header-top-area-->
				<div class="header-mid-area ptb-10">
					<div class="container">
						<div class="row">
							<div class="col-md-3">
								<div class="logo-area">
									<div class="logo">
										<a href="<?= Yii::$app->homeUrl ?>" class="header__logo"><img src="/img/logo.png" alt=""></a>
									</div>
								</div>
							</div>
							<div class="col-md-7">
								<div class="custom-menu custom-menu6 hidden-sm hidden-xs">
									<nav>	
										<ul>
											<?= BlockMenu::main() ?>
										</ul>
									</nav>
								</div>
							</div>
							
							<div class="col-md-2">
								<div class="detop">
									<div class="minicart-area">
										<?= CartInformer::widget(['htmlTag' => 'a', 'cssClass' => 'showcart', 'offerUrl' => '/cart', 'text' => '<span class="text"></span><span class="counter"><span class="counter-number">{c}</span></span>']); ?>
									</div>
									<div class="wish-link">
										<?= FavInformer::widget(['htmlTag' => 'a', 'cssClass' => 'showfav', 'offerUrl' => '/favorites', 'text' => '<span class="text"></span><span class="counter"><span class="counter-number">{c}</span></span>']); ?>
									</div>
								</div>
							</div>
					
						</div>
					</div>
				</div>
				<!--/header-mid-area-->
				<div class="header-bottom-area header-bottom-area6">
					
					<!--/sticker menu-->
					<div id="sticker" class="sticker hidden-sm hidden-xs">
						<div class="container">
							<div class="row">
								<div class="col-md-9">
									<div class="custom-menu custom-menu6">
										<nav>	
											<ul>
												<?= BlockMenu::main() ?>
											</ul>
										</nav>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--/sticker menu-->
					<div class="mobile-menu-area">
						<div class="container">
							<div class="row">
								<div class="col-md-12">
									<div class="mobile-menu hidden-md hidden-lg">
										<nav>	
											<ul>
												<li>
													<?= \app\modules\search\components\BlockForm::_search() ?>
												</li>
												<?php if(Yii::$app->user->isGuest): ?>
													<li><a href="/account/login">Вход</a></li>
												<?php else: ?>
													<?php if(Yii::$app->user->can('adminPanel')):?>
														<li><a href="/admin/main">Админка</a></li>
													<?php else: ?>
														<li><a href="/account">Личный кабинет</a></li>
													<?php endif; ?>
												<?php endif; ?>
												<?= BlockMenu::main('m-') ?>
											</ul>
										</nav>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--/mobile-menu-area-->
				</div>
				<!--/header-bottom-area-->
			</header>
			<!--/header-->

			<main class="main-content main-content3">
				<?= $content ?>
			</main>
			
			<!--footer-container-->
			<footer class="footer-container">
				<div class="footer-middle footer-middle6 ptb-60">
					<div class="container">
						<div class="row">
							<div class="col-md-4">
								<div class="footer-contact">
									<div class="section-title section-title6">
										<h2>Контакты</h2>
									</div>
									<?= $this->params['siteinfo']->address ?>
									<ul>
										<li><strong>Телефон:</strong> <?= $this->params['siteinfo']->phone ?></li>
										<li><strong>Email:</strong> <?= $this->params['siteinfo']->email ?></li>
									</ul>
								</div>
							</div>
							<div class="col-md-4">
								<?= BlockText::_('footer_left_block') ?>
							</div>
							<div class="col-md-4">
								<ul class="link-follow">
									<?= BlockMenu::social() ?>
								</ul>
								<?//= round(memory_get_usage() / (1024 * 1024), 2) ?> <!-- Потребление памяти -->
							</div>
						</div>
					</div>
				</div>
				<!--/footer-middle-->
				<div class="footer-bottom ptb-20">
					<div class="container">
						<div class="row">
							<div class="col-md-5">
								<div class="copyright copyright6"><span><?= $this->params['siteinfo']->copyright ?> &copy; <?= date('Y') ?></b><br></span>
								</div>
							</div>
							<div class="col-md-7">
								<div class="footer-payment">
									<img src="/img/payment.png" alt="">
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--/footer-bottom-->
			</footer>
			<!--/footer-container-->
		</div>
		<!--/body-wrapper-->
	</div>
	<!--/page-wrapper-->
	
	<?= BlockForm::_recall() ?>
	<?= Alert::widget() ?>
	<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
