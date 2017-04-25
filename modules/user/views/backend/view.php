<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Аккаунт', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-xs btn-primary']) ?>
		<?= Html::a('Изменить пароль', ['password-change', 'id' => $model->id], ['class' => 'btn btn-xs btn-warning']) ?>
    </p>
	
	<div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6">
			<?= DetailView::widget([
				'model' => $model,
				'attributes' => [
					'created_at:datetime',
					'username',
					'email:email',
					'role',
					[
						'label' => 'Статус',
						'value' => ($model->status)? '<p class="text-success">Активный</p>':'<p class="text-danger">Неактивный</p>',
						'format' => 'html',
					],
				],
			]) ?>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-6">
			<?php if($model->profile):?>
				<?= $this->renderFile('@app/modules/profile/views/backend/view.php', [
					'model' => $model->profile,
				]) ?>
			<?php endif;?>
		</div>
	</div>
	
	<hr>
	
	<div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6">
			<h3>Адреса пользователя</h3>
			<p>
				<a class="btn btn-success btn-xs" href="/admin/address/create?user_id=<?= $model->id ?>&redirect=view">Добавить адрес</a>
			</p>
			
			<table id="w1" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>#</th>
						<th>Наименование</th>
						<th>Город</th>
						<th>Адрес</th>
						<th class="action-column">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<?php if($model->addresses):?>
						<?php foreach($model->addresses as $key => $address):?>
							<tr class="treegrid-1" data-key="<?= $key+1 ?>">
								<td><span class="treegrid-expander"></span><?= $key+1 ?></td>
								<td><?= $address->title ?></td>
								<td><?= $address->city ?></td>
								<td><?= $address->address ?></td>
								<td>
									<p class="text-right">
										<a href="/admin/address/update?id=<?= $address->id ?>&redirect=view" title="Редактировать" aria-label="Редактировать" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;&nbsp;
										<a href="/admin/address/delete?id=<?= $address->id ?>&redirect=view" title="Удалить" aria-label="Удалить" data-confirm="Вы уверены, что хотите удалить этот элемент?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>
									</p>
								</td>
							</tr>
						<?php endforeach;?>
					<?php else: ?>
						<tr>
							<td colspan="5"><h5>Нет адресов</h5></td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-6">
			<h3>Организации пользователя</h3>
			<p>
				<a class="btn btn-success btn-xs" href="/admin/company/create?user_id=<?= $model->id ?>&redirect=view">Добавить организацию</a>
			</p>
			
			<table id="w1" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>#</th>
						<th>Наименование организации</th>
						<th>ИНН</th>
						<th class="action-column">&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<?php if($model->companies):?>
						<?php foreach($model->companies as $key => $company):?>
							<tr class="treegrid-1" data-key="<?= $key+1 ?>">
								<td><span class="treegrid-expander"></span><?= $key+1 ?></td>
								<td><?= $company->company ?></td>
								<td><?= $company->inn ?></td>
								<td>
									<p class="text-right">
										<a href="/admin/company/update?id=<?= $company->id ?>&redirect=view" title="Редактировать" aria-label="Редактировать" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>&nbsp;&nbsp;
										<a href="/admin/company/delete?id=<?= $company->id ?>&redirect=view" title="Удалить" aria-label="Удалить" data-confirm="Вы уверены, что хотите удалить этот элемент?" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>
									</p>
								</td>
							</tr>
						<?php endforeach;?>
					<?php else: ?>
						<tr>
							<td colspan="4"><h5>Нет организаций</h5></td>
						</tr>
					<?php endif; ?>
				</tbody>
			</table>
        </div>
    </div>
</div>
