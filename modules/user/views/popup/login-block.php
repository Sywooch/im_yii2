<?php
//use Yii;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
?>
<?php if(Yii::$app->user->isGuest): ?>

	<div class="account-toggle">
		<a href="#">Личный кабинет <i class="fa fa-angle-down"></i></a>
	</div>
	<ul class="show-account-toggle">
		<li><a href="#login" class="fancybox">Вход</a></li> 
		<li><a href="#reg" class="fancybox">Регистрация</a></li> 
	</ul>
	
	<div id="login" class="fancy-hidden">
		<?php $form = ActiveForm::begin([
			'id' => 'auth_form',
			'action' => '/account/user-login',
			'method' => 'post',
			'options' => ['class' => 'form'],
			'fieldConfig' => [
				'template' => '{input}{error}',
				'errorOptions' => ['class' => 'error'],
			],
			'errorCssClass' => 'error',
		]); ?>
		
		<div class="section-title section-title-shop">
			<h3>Вход в личный кабинет</h3>
		</div>
		
		<?= $form->field($model, 'username')->textInput(['placeholder' => 'Логин']) ?>
		<?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Пароль']) ?>
		<?//= $form->field($model, 'rememberMe')->checkbox([
			/* 'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>", */
		//]) ?>
		<div class="form-group submit-group">
			<button type="submit" class="button">Войти</button>
		</div>

		<?//= Html::a('Регистрация', ['/account/signup']) ?>
		<?//= Html::a('Восстановление пароля', ['/account/password-reset-request']) ?>
		
		<p><!--<a href="#reg" class="fancybox">Регистрация</a>&nbsp;&nbsp;&nbsp;--><a href="#recover" class="fancybox">Забыли пароль?</a></p>
		<p><span class="r">*</span>Все поля обязательны для заполнения</p>
		<?php ActiveForm::end(); ?>
	</div>
	
	<div id="login" class="fancy-hidden">
		<form id="auth_form" method="post" class="form">
			<div class="section-title section-title-shop">
				<h3>Вход в личный кабинет</h3>
			</div>
			
			<div id="auth_message" style="display:none;"></div>
			<div class="form-group">
				<label for="login">Ваш e-mail<span class="r">*</span></label> <input name="login" type="text" placeholder="Ваш e-mail">
			</div>
			<div class="form-group">
				<label for="password">Ваш пароль<span class="r">*</span></label> <input name="password" type="password" placeholder="Ваш пароль">
			</div>
			<div class="form-group submit-group">
				<button type="submit" class="button">Войти<?//= $text_login ?> <img src="/images/blink-blue.gif" class="loading" style="display:none;"></button>
			</div>

			<p><!--<a href="#reg" class="fancybox">Регистрация</a>&nbsp;&nbsp;&nbsp;--><a href="#recover" class="fancybox">Забыли пароль?</a></p>
			<p><span class="r">*</span>Все поля обязательны для заполнения</p>
		</form>
	</div>
	
	<div id="recover" class="fancy-hidden">
		<form id="recovery_form" method="post" class="form">
			<div class="section-title section-title-shop">
				<h3>Восстановление пароля</h3>
			</div>
			
			<div id="recovery_message" style="display:none;"></div>
			<div class="form-group">
				<label for="login">Ваш E-mail<span class="r">*</span></label> <input name="login" type="text" placeholder="Ваш E-mail">
			</div>
			<div class="form-group submit-group">
				<button type="submit" class="button">Отправить <img src="/images/blink-blue.gif" class="loading" style="display:none;"></button>
			</div>
		</form>
	</div>

	<div id="reg" class="fancy-hidden">
		<form id="reg_form" method="post" class="form">
			<div class="section-title section-title-shop">
				<h3>Регистрация</h3>
			</div>
			
			<div id="reg_message" style="display:none;"></div>
			
			<div class="form-group">
				<label for="name">ФИО<span class="r">*</span></label> <input name="name" type="text" placeholder="ФИО(контактное лицо)">
			</div>
			<div class="form-group">
				<label for="email">E-mail<span class="r">*</span></label> <input name="email" type="text" placeholder="E-mail">
			</div>
			<div class="form-group">
				<label for="phone">Телефон<span class="r">*</span></label> <input name="phone" type="text" class="phone" placeholder="Контактный телефон">
			</div>
			<div class="form-group">
				<label for="password">Пароль<span class="r">*</span></label> <input name="password" id="password" type="password" placeholder="Пароль">
			</div>
			<div class="form-group">
				<label for="password2">Повторите пароль<span class="r">*</span></label> <input name="password2" type="password" placeholder="Повторите пароль">
			</div>
			<input type="hidden" name="user_type" value="1">
			<!--<div class="checkbox">
				<label><input type="radio" name="user_type" value="1" checked> Я частное лицо</label>
			</div>
			<div class="checkbox">
				<label><input type="radio" name="user_type" value="2"> Я являюсь представителем юрлица</label>
			</div>
			<div class="checkbox">
				<label><input type="checkbox" name="subscription" value="1" id="subscription2" checked> Я не против рассылки новостей и акций</label>
			</div>-->
			<div class="checkbox">
				<label><input type="checkbox" name="agree" value="1"> Я согласен с использованием моих персональных данных</label>
			</div>
			<div class="form-group submit-group">
				<button type="submit" class="button">Сохранить <img src="/images/blink-blue.gif" class="loading" style="display:none;"></button>
			</div>
			
			<p><span class="r">*</span>Все поля обязательны для заполнения</p>
			<p>Уже зарегистрированы? <a href="#login" class="fancybox">Войти</a></p>
		</form>
	</div>
	
<?php else: ?>

	<?php if(Yii::$app->user->can('adminPanel')):?>
	
		<div class="account-toggle">
			<a href="#"> (admin) <i class="fa fa-angle-down"></i></a>
		</div>
		<ul class="show-account-toggle">
			<li><a href="/admin/main">В админку</a></li> 
			<li><a href="/account/logout" data-method="post">Выйти</a></li> 
		</ul>
		
	<?php else: ?>
		
		<div class="account-toggle">
			<a href="#"> (пользватель) <i class="fa fa-angle-down"></i></a>
		</div>
		<ul class="show-account-toggle">
			<li><a href="/account">Аккаунт</a></li> 
			<li><a href="/favorites">Избранное</a></li> 
			<li><a href="/cart">Корзина</a></li> 
			<li><a href="/account/logout" data-method="post">Выйти</a></li> 
		</ul>
		
	<?php endif; ?>
<?php endif; ?>