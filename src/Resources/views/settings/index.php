<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use RS\Component\Core\Widget\SettingsMenu;

$this->title = 'Настройки';
$this->params['subtitle'] = 'Трейд';

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="row">

	<div class="col-md-3">
		<?= SettingsMenu::widget() ?>
	</div>

	<div class="col-md-9">
		<?php $activeForm = ActiveForm::begin([
			'action' => Url::toRoute(['index']),
		]); ?>
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#main" data-toggle="tab" aria-expanded="true">Основные</a></li>
				</ul>

				<div class="tab-content">
					<div class="tab-pane active" id="main">
					    <?= $activeForm->field($form, 'default_out_url')
								->textInput(['maxlength' => true, 'placeholder' => 'https://google.com/'])
								->label('Урл для слива по умолчанию')
					    		->hint('Урл для слива "плохого" трафика, или дефолтный урл для нештатных ситуаций.')
					    ?>

					    <?= $activeForm->field($form, 'skim')
								->textInput(['maxlength' => true, 'placeholder' => 90])
								->label('Ским')
								->hint('Дефолтный ским (вероятность перехода на контент в процентах). 
										Приоритет отдается скиму, указанному в урле, затем этот.')
					    ?>

					    <?= $activeForm->field($form, 'noref_skim')
					    		->textInput(['maxlength' => true])
					    		->label('Ским без рефера')
					    		->hint('Вероятность перехода на контент в процентах для пользователей без рефера.')
					    ?>
					</div>
				</div>

				<div class="box-footer clearfix">
				    <div class="form-group">
						<?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
					</div>
				</div>
			</div>
		<?php ActiveForm::end() ?>

	</div>
</div>
