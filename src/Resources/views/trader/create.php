<?php

use yii\helpers\Html;

$this->title = Yii::t('trade', 'trade');
$this->params['subtitle'] = Yii::t('trade', 'new');

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('trade', 'traders'),
    'url' => ['index']
];
$this->params['breadcrumbs'][] = Yii::t('trade', 'new');

?>

<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-plus"></i><h3 class="box-title"><?= Yii::t('trade', 'new') ?></h3>
    </div>

    <div class="box-body pad">
        <?= $this->render('_form', [
            'form' => $form,
        ]) ?>
    </div>

    <div class="box-footer">
        <?= Html::submitButton(Yii::t('trade', 'add'), ['class' => 'btn btn-default', 'form' => 'trader-form']) ?>
        <?= Html::a(Yii::t('trade', 'to_list'), ['index'], ['class' => 'btn btn-warning']) ?>
    </div>
</div>
