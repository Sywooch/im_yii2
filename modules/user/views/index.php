<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;

use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$script1 = <<< JS
	function getZones(elem){
		$.post(
			'/city/default/current-zones',
			'cityId=' + elem.value
		)
		.done(function(result){
			if(result){
				$('#zones .form-checkbox-group').html(result);
			} else {
				$('#zones .form-checkbox-group').html(' ... нет ... ');
			}
		});
	}
JS;

$script2 = <<< JS
	$('#pn_current_time_wraper .time').timepicker({
		'showDuration': true,
		'step': 60,
		'timeFormat': 'H:i'
	});
	
	$('#vt_current_time_wraper .time').timepicker({
		'showDuration': true,
		'step': 60,
		'timeFormat': 'H:i'
	});
	
	$('#sr_current_time_wraper .time').timepicker({
		'showDuration': true,
		'step': 60,
		'timeFormat': 'H:i'
	});
	
	$('#cht_current_time_wraper .time').timepicker({
		'showDuration': true,
		'step': 60,
		'timeFormat': 'H:i'
	});
	
	$('#pt_current_time_wraper .time').timepicker({
		'showDuration': true,
		'step': 60,
		'timeFormat': 'H:i'
	});
	
	$('#sb_current_time_wraper .time').timepicker({
		'showDuration': true,
		'step': 60,
		'timeFormat': 'H:i'
	});
	
	$('#vs_current_time_wraper .time').timepicker({
		'showDuration': true,
		'step': 60,
		'timeFormat': 'H:i'
	});

	var pnCurrentTimeWraper = document.getElementById('pn_current_time_wraper');
	var vtCurrentTimeWraper = document.getElementById('vt_current_time_wraper');
	var srCurrentTimeWraper = document.getElementById('sr_current_time_wraper');
	var chtCurrentTimeWraper = document.getElementById('cht_current_time_wraper');
	var ptCurrentTimeWraper = document.getElementById('pt_current_time_wraper');
	var sbCurrentTimeWraper = document.getElementById('sb_current_time_wraper');
	var vsCurrentTimeWraper = document.getElementById('vs_current_time_wraper');
	
	var timeOnlyDatepair = new Datepair(pnCurrentTimeWraper);
	var timeOnlyDatepair = new Datepair(vtCurrentTimeWraper);
	var timeOnlyDatepair = new Datepair(srCurrentTimeWraper);
	var timeOnlyDatepair = new Datepair(chtCurrentTimeWraper);
	var timeOnlyDatepair = new Datepair(ptCurrentTimeWraper);
	var timeOnlyDatepair = new Datepair(sbCurrentTimeWraper);
	var timeOnlyDatepair = new Datepair(vsCurrentTimeWraper);
JS;

$this->registerJs($script1, yii\web\View::POS_END);
$this->registerJs($script2, yii\web\View::POS_END);
?>

<!-- Section -->
<section class="section">
	<h1>Заголовок</h1>
	<p>Для регистрации на сайте зарегистрируйтесь на сайте</p>
	
	<!--<div class="alert-box danger">
		<i class="fa fa-exclamation-triangle"></i>
		<p>Ошибка заполнения полей сообщения:</p>
		<ul>
			<li>Обязательное поле Имя</li>
			<li>Обязательное поле Пароль</li>
			<li>Выберите хотябы один район</li>
		</ul>
	</div>-->
				
	<!--<div class="alert-box success">
		<i class="fa fa-check-circle-o"></i>
		<p>Для окончания регистрации проверьте свою почту и перейдите по ссылке в письме</p>
	</div>-->
				
	<div class="tabs">
		<div class="tab-header">
			<ul>
				<li class="active-tab"><a href="#tab1-1"><i class="fa fa-fw fa-sign-in"></i>  Вход</a></li>
				<li><a href="#tab1-2"><i class="fa fa-fw fa-user-plus"></i>  Регистрация для родителей</a></li>
				<li><a href="#tab1-4"><i class="fa fa-fw fa-female"></i>  Регистрация для нянь</a></li>
				<li><a href="#tab1-3"><i class="fa fa-fw fa-question-circle"></i>  Восстановление пароля</a></li>
			</ul>
		</div>
		<div class="tab-content">
			<div id="tab1-1" class="tab">
				<div role="form" class="wpcf7">
					<?php $form1 = ActiveForm::begin([
						'id' => 'login-form',
						'method' => 'post',
						'options' => ['class' => 'wpcf7-form'],
						'fieldConfig' => [
							'template' => '{input}{error}',
							'errorOptions' => ['class' => 'error'],
						],
						'errorCssClass' => 'error',
					]); ?>
						<div class="row">
							<div class="col-sm-6">
								<div class="input-container">
									<i class="fa fa-fw fa-at">
									</i>
									<span class="wpcf7-form-control-wrap your-email">
										<?= $form1->field($loginModel, 'username')->textInput(['class' => 'wpcf7-form-control wpcf7-text wpcf7-email', 'placeholder' => 'E-mail']) ?>
									</span>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="input-container">
									<i class="fa fa-fw fa-lock">
									</i>
									<span class="wpcf7-form-control-wrap your-name">
										<?= $form1->field($loginModel, 'password')->passwordInput(['class' => 'wpcf7-form-control wpcf7-text', 'placeholder' => 'Пароль']) ?>
									</span>
								</div>
							</div>
							<div class="col-sm-12">
								<?= $form1->field($loginModel, 'rememberMe')->checkbox() ?>
								<?= Html::submitButton('Войти на сайт', ['class' => 'wpcf7-form-control wpcf7-submit button color-white bg-orange', 'name' => 'login-button']) ?>
							</div>
						</div>
					<?php ActiveForm::end(); ?>
				</div>
			</div>
			
			<div id="tab1-2" class="tab">
				<div role="form" class="wpcf7">
					
					<?php $form2 = ActiveForm::begin([
						'id' => 'form-signup-min',
						'method' => 'post',
						'options' => ['class' => 'wpcf7-form'],
						'fieldConfig' => [
							'template' => '{input}{error}',
							'errorOptions' => ['class' => 'error'],
						],
						'errorCssClass' => 'error',
					]); ?>
					
					<?= $form2->field($profileModel, 'account_type')->hiddenInput(['value' => 1]) ?>
					<?= $form2->field($profileModel, 'tarif_type')->hiddenInput(['value' => 0]) ?>
					
						<div class="row">
							<div class="col-sm-6">
								<div class="input-container">
									<i class="fa fa-fw fa-at">
									</i>
									<span class="wpcf7-form-control-wrap your-email">
										<?= $form2->field($signupModel, 'email')->textInput(['class' => 'wpcf7-form-control wpcf7-text wpcf7-email', 'placeholder' => 'E-mail']) ?>
									</span>
								</div>
								<div class="input-container">
									<i class="fa fa-fw fa-lock">
									</i>
									<span class="wpcf7-form-control-wrap your-name">
										<?= $form2->field($signupModel, 'password')->passwordInput(['class' => 'wpcf7-form-control wpcf7-text', 'placeholder' => 'Пароль']) ?>
									</span>
								</div>
								<div class="input-container">
									<?= $form2->field($signupModel, 'verifyCode')->widget(Captcha::className(), [
										'captchaAction' => '/user/default/captcha',
										'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
									]) ?>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="input-container">
									<i class="fa fa-fw fa-user">
									</i>
									<span class="wpcf7-form-control-wrap your-name">
										<?= $form2->field($profileModel, 'name')->textInput(['class' => 'wpcf7-form-control wpcf7-text', 'placeholder' => 'Имя']) ?>
									</span>
								</div>
								<div class="input-container">
									<i class="fa fa-fw fa-phone">
									</i>
									<span class="wpcf7-form-control-wrap your-name">
										<?= $form2->field($profileModel, 'phone')->textInput(['class' => 'wpcf7-form-control wpcf7-text', 'placeholder' => 'Телефон']) ?>
									</span>
								</div>
							</div>
							<div class="col-sm-12">
								<?= Html::submitButton('Зарегистрироваться на сайте', ['class' => 'wpcf7-form-control wpcf7-submit button color-white bg-orange', 'name' => 'signup-button']) ?>
							</div>				
						</div>
					<?php ActiveForm::end(); ?>
				</div>
			</div>
			
			<div id="tab1-4" class="tab">
			
				<?php $form3 = ActiveForm::begin([
					'id' => 'form-signup-full',
					'method' => 'post',
					'options' => ['class' => 'wpcf7-form', 'enctype' => 'multipart/form-data'],
					'fieldConfig' => [
						'template' => '{input}{error}',
						'errorOptions' => ['class' => 'error'],
					],
					'errorCssClass' => 'error',
				]); ?>
				
				<?= $form3->field($profileModel, 'account_type')->hiddenInput(['value' => 0]) ?>
				<?= $form3->field($profileModel, 'tarif_type')->hiddenInput(['value' => 0]) ?>
				
					<div class="row">
						<div class="col-sm-6">
							<div class="input-container">
								<i class="fa fa-fw fa-at">
								</i>
								<span class="wpcf7-form-control-wrap your-email">
									<?= $form3->field($signupModel, 'email')->textInput(['class' => 'wpcf7-form-control wpcf7-text wpcf7-email', 'placeholder' => 'E-mail']) ?>
								</span>
							</div>
							<div class="input-container">
								<i class="fa fa-fw fa-phone">
								</i>
								<span class="wpcf7-form-control-wrap your-name">
									<?= $form3->field($profileModel, 'phone')->textInput(['class' => 'wpcf7-form-control wpcf7-text', 'placeholder' => 'Телефон']) ?>
								</span>
							</div>
							<div class="input-container">
								<i class="fa fa-fw fa-lock">
								</i>
								<span class="wpcf7-form-control-wrap your-name">
									<?= $form3->field($signupModel, 'password')->passwordInput(['class' => 'wpcf7-form-control wpcf7-text', 'placeholder' => 'Пароль']) ?>
								</span>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="input-container">
								<i class="fa fa-fw fa-user">
								</i>
								<span class="wpcf7-form-control-wrap your-name">
									<?= $form3->field($profileModel, 'lastname')->textInput(['class' => 'wpcf7-form-control wpcf7-text', 'placeholder' => 'Фамилия']) ?>
								</span>
							</div>
							<div class="input-container">
								<i class="fa fa-fw fa-user">
								</i>
								<span class="wpcf7-form-control-wrap your-name">
									<?= $form3->field($profileModel, 'name')->textInput(['class' => 'wpcf7-form-control wpcf7-text', 'placeholder' => 'Имя']) ?>
								</span>
							</div>
							<div class="input-container">
								<i class="fa fa-fw fa-user">
								</i>
								<span class="wpcf7-form-control-wrap your-name">
									<?= $form3->field($profileModel, 'phathername')->textInput(['class' => 'wpcf7-form-control wpcf7-text', 'placeholder' => 'Отчество']) ?>
								</span>
							</div>
						</div>
					</div>
					
					<h4>Дополнительная информация</h4>
					
					<div class="row">
						<div class="col-sm-6">
							<div class="input-container">
								<i class="fa fa-fw fa-users"></i>
								<?= $form3->field($profileModel, 'age')->textInput(['placeholder' => 'Возраст']) ?>
							</div>
							<div class="input-container">
								<i class="fa fa-fw fa-graduation-cap"></i>
								<?= $form3->field($profileModel, 'education')->textarea(['cols' => 40, 'rows' => 5, 'placeholder' => 'Образование']) ?>
							</div>
							<div class="input-container">
								<i class="fa fa-fw fa-smile-o"></i>
								<?= $form3->field($profileModel, 'experience')->textarea(['cols' => 40, 'rows' => 5, 'placeholder' => 'Опыт работы с детьми']) ?>
							</div>
							<div class="input-container">
								<i class="fa fa-fw fa-fire-extinguisher"></i>
								<?= $form3->field($profileModel, 'skills')->textarea(['cols' => 40, 'rows' => 5, 'placeholder' => 'Навыки']) ?>
							</div>
							<div class="input-container">
								<h4>Удобное время работы</h4>
								<hr>
								<div class="row" id="pn_current_time_wraper">
									<div class="col-sm-6">Понедельник</div>
									<div class="col-sm-3"><?= Html::textInput('Profile[pn_start]', null, ['class' => 'time-input time start', 'placeholder' => 'от..']) ?></div>
									<div class="col-sm-3"><?= Html::textInput('Profile[pn_end]', null, ['class' => 'time-input time end', 'placeholder' => 'до..']) ?></div>
								</div>
								<div class="row" id="vt_current_time_wraper">
									<div class="col-sm-6">Вторник</div>
									<div class="col-sm-3"><?= Html::textInput('Profile[vt_start]', null, ['class' => 'time-input time start', 'placeholder' => 'от..']) ?></div>
									<div class="col-sm-3"><?= Html::textInput('Profile[vt_end]', null, ['class' => 'time-input time end', 'placeholder' => 'до..']) ?></div>
								</div>
								<div class="row" id="sr_current_time_wraper">
									<div class="col-sm-6">Среда</div>
									<div class="col-sm-3"><?= Html::textInput('Profile[sr_start]', null, ['class' => 'time-input time start', 'placeholder' => 'от..']) ?></div>
									<div class="col-sm-3"><?= Html::textInput('Profile[sr_end]', null, ['class' => 'time-input time end', 'placeholder' => 'до..']) ?></div>
								</div>
								<div class="row" id="cht_current_time_wraper">
									<div class="col-sm-6">Четверг</div>
									<div class="col-sm-3"><?= Html::textInput('Profile[cht_start]', null, ['class' => 'time-input time start', 'placeholder' => 'от..']) ?></div>
									<div class="col-sm-3"><?= Html::textInput('Profile[cht_end]', null, ['class' => 'time-input time end', 'placeholder' => 'до..']) ?></div>
								</div>
								<div class="row" id="pt_current_time_wraper">
									<div class="col-sm-6">Пятница</div>
									<div class="col-sm-3"><?= Html::textInput('Profile[pt_start]', null, ['class' => 'time-input time start', 'placeholder' => 'от..']) ?></div>
									<div class="col-sm-3"><?= Html::textInput('Profile[pt_end]', null, ['class' => 'time-input time end', 'placeholder' => 'до..']) ?></div>
								</div>
								<div class="row" id="sb_current_time_wraper">
									<div class="col-sm-6">Суббота</div>
									<div class="col-sm-3"><?= Html::textInput('Profile[sb_start]', null, ['class' => 'time-input time start', 'placeholder' => 'от..']) ?></div>
									<div class="col-sm-3"><?= Html::textInput('Profile[sb_end]', null, ['class' => 'time-input time end', 'placeholder' => 'до..']) ?></div>
								</div>
								<div class="row" id="vs_current_time_wraper">
									<div class="col-sm-6">Воскресенье</div>
									<div class="col-sm-3"><?= Html::textInput('Profile[vs_start]', null, ['class' => 'time-input time start', 'placeholder' => 'от..']) ?></div>
									<div class="col-sm-3"><?= Html::textInput('Profile[vs_end]', null, ['class' => 'time-input time end', 'placeholder' => 'до..']) ?></div>
								</div>
								<hr>
							</div>
							
							<div class="input-container">
								<?= $form3->field($signupModel, 'verifyCode')->widget(Captcha::className(), [
									'captchaAction' => '/user/default/captcha',
									'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
								]) ?>
							</div>
						</div>
						<div class="col-sm-6">
							
							<div class="input-container">
								<i class="fa fa-fw fa-money"></i>
								<?= $form3->field($profileModel, 'price')->textInput(['placeholder' => 'Стоимость работы в час']) ?>
							</div>
							
							<div class="input-container">
								<i class="fa fa-fw fa-file-text "></i>
								<?= $form3->field($profileModel, 'doc_list')->textarea(['cols' => 40, 'rows' => 5, 'placeholder' => 'Перечень имеющихся медицинских документов']) ?>
							</div>
							
							<div class="input-container">
								<div class="checkbox">
									<?= $form3->field($profileModel, 'is_ksiva')->checkbox() ?>
								</div>
							</div>
							
							<hr>
							
							<div class="input-container">
								<h4>Город и районы работы</h4>
								<?= $form3->field($profileModel, 'city_id')->dropDownList(ArrayHelper::map($cities, 'id', 'title'), ['onchange' => 'getZones(this)', 'prompt' => '.. выберите город ..']) ?>
			
								<div id="zones">
									<h4>районы</h4>
									<div class="form-checkbox-group">
										... нет ...
									</div>
								</div>
							</div>
							
							<hr>
							
							<div class="input-container error">
								<h4>Возраст ребенка</h4>
								<div class="checkbox">
									<?= $form3->field($profileModel, 'child_age_1')->checkbox() ?>
								</div>
								<div class="checkbox">
									<?= $form3->field($profileModel, 'child_age_2')->checkbox() ?>
								</div>
								<div class="checkbox">
									<?= $form3->field($profileModel, 'child_age_3')->checkbox() ?>
								</div>
								<div class="checkbox">
									<?= $form3->field($profileModel, 'child_age_4')->checkbox() ?>
								</div>
								<div class="checkbox">
									<?= $form3->field($profileModel, 'child_age_5')->checkbox() ?>
								</div>
							</div>
							<div class="input-container">
								<h4>Возможность работы</h4>
								<div class="checkbox">
									<?= $form3->field($profileModel, 'is_many_childs')->checkbox() ?>
								</div>
								<div class="checkbox">
									<?= $form3->field($profileModel, 'is_disease_childs')->checkbox() ?>
								</div>
								<div class="checkbox">
									<?= $form3->field($profileModel, 'is_invalid_childs')->checkbox() ?>
								</div>
							</div>
							<div class="input-container">
								<h4>Прочее</h4>
								<div class="checkbox">
									<?= $form3->field($profileModel, 'is_escort')->checkbox() ?>
								</div>
								<div class="checkbox">
									<?= $form3->field($profileModel, 'is_events')->checkbox() ?>
								</div>
								<div class="checkbox">
									<?= $form3->field($profileModel, 'is_homework')->checkbox() ?>
								</div>
								<div class="checkbox">
									<?= $form3->field($profileModel, 'is_trial')->checkbox() ?>
								</div>
							</div>
							<h4>Медиа</h4>
							<div class="input-container">
								<label for="photo">Фотографии</label>
								<?= Html::fileInput('Profile[imageGallery][]', null, ['multiple' => true, 'accept' => 'image/*']) ?>
							</div>
							<div class="input-container">
								<i class="fa fa-fw fa-play"></i>
								<?= $form3->field($profileModel, 'video')->textarea(['cols' => 40, 'rows' => 5, 'placeholder' => 'Ссылка на видеоролик youtube']) ?>
							</div>
							
							
						</div>
						
						<div class="col-sm-12">
							<?= Html::submitButton('Зарегистрировать анкету на сайте', ['class' => 'wpcf7-form-control wpcf7-submit button color-white bg-orange', 'name' => 'signup-button']) ?>
						</div>
					</div>
				<?php ActiveForm::end(); ?>
			</div>
			
			<div id="tab1-3" class="tab">
				<?php $form4 = ActiveForm::begin([
					'id' => 'request-password-reset-form', 
					'method' => 'post',
					'options' => ['class' => 'wpcf7-form'],
					'fieldConfig' => [
						'template' => '{input}{error}',
						'errorOptions' => ['class' => 'error'],
					],
					'errorCssClass' => 'error',
				]); ?>
					<div class="row">
						<div class="col-sm-6">
							<div class="input-container">
								<i class="fa fa-fw fa-at">
								</i>
								<span class="wpcf7-form-control-wrap your-email">
									<?= $form4->field($resetModel, 'email')->textInput(['class' => 'wpcf7-form-control wpcf7-text wpcf7-email', 'placeholder' => 'E-mail']) ?>
								</span>
							</div>
						</div>
						<div class="col-sm-6">
							<?= Html::submitButton('Восстановить пароль', ['class' => 'wpcf7-form-control wpcf7-submit button color-white bg-orange']) ?>
						</div>
					</div>
				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
</section>
<!-- /Section -->