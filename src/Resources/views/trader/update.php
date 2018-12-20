<?php

use yii\helpers\Html;

$this->title = Yii::t('trade', 'trade');
$this->params['subtitle'] = Yii::t('trade', 'edit');

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('trade', 'trade'),
    'url' => ['index']
];
$this->params['breadcrumbs'][] = Yii::t('trade', 'edit');

?>

<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-edit"></i><h3 class="box-title"><?= Yii::t('trade', 'edit_name', ['name' => $trader->name]) ?></h3>

        <div class="box-tools pull-right">
            <div class="btn-group">
                <?= Html::a('<i class="fa fa-plus text-green"></i> ' . Yii::t('trade', 'add'), ['create'], ['class' => 'btn btn-default btn-sm']) ?>
                <?= Html::a('<i class="fa fa-info-circle text-blue"></i> ' . Yii::t('trade', 'info'), ['view', 'id' => $trader->getId()], ['class' => 'btn btn-default btn-sm']) ?>
                <?= Html::a('<i class="fa fa-trash text-red"></i> ' . Yii::t('trade', 'delete'), ['delete', 'id' => $trader->getId()], [
                    'class' => 'btn btn-default btn-sm',
                    'data' => [
                        'confirm' => Yii::t('trade', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        </div>
    </div>

    <div class="box-body pad">
        <?= $this->render('_form', [
            'form' => $form,
        ]) ?>
    </div>

    <div class="box-footer">
        <?= Html::submitButton(Yii::t('trade', 'save'), ['class' => 'btn btn-default', 'form' => 'trader-form']) ?>
        <?= Html::a(Yii::t('trade', 'to_list'), ['index'], ['class' => 'btn btn-warning']) ?>
    </div>
</div>
