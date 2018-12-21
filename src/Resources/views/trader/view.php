<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = Yii::t('trade', 'trade');
$this->params['subtitle'] = Yii::t('trade', 'info');

$this->params['breadcrumbs'][] = [
    'label' => Yii::t('trade', 'trade'),
    'url' => ['index']
];
$this->params['breadcrumbs'][] = Yii::t('trade', 'info');

?>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-info-circle text-blue"></i><?= Yii::t('trade', 'info') ?></h3>

        <div class="box-tools pull-right">
            <div class="btn-group">
                <?= Html::a('<i class="fa fa-plus text-green"></i> ' . Yii::t('trade', 'add'), ['create'], ['class' => 'btn btn-default btn-sm']) ?>
                <?= Html::a('<i class="fa fa-edit text-blue"></i> ' . Yii::t('trade', 'edit'), ['update', 'id' => $trader->getId()], ['class' => 'btn btn-default btn-sm']) ?>
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
        <?= DetailView::widget([
            'model' => $trader,
            'attributes' => [
                'trader_id',
                'name',
                'trade_url:url',
                'forces_tally',
                'enabled',
                'updated_at:datetime',
                'created_at:datetime',
            ],
        ]) ?>
    </div>

    <div class="box-footer">
        <?= Html::a(Yii::t('trade', 'to_list'), ['index'], ['class' => 'btn btn-warning']) ?>
    </div>
</div>
