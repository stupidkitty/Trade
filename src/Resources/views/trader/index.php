<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\ActionColumn;

$this->title = Yii::t('trade', 'trade');
$this->params['subtitle'] = Yii::t('trade', 'overview');

if ($page <= 1) {
    $tableTitle = Yii::t('trade', 'traders');

    $this->params['breadcrumbs'][] = Yii::t('trade', 'trade');
} else {
    $tableTitle = Yii::t('trade', 'text_with_page_num', [
        'text' => Yii::t('trade', 'traders'),
        'page' => $page,
        'separator' => '-'
    ]);

    $this->params['breadcrumbs'][] = [
        'label' => Yii::t('trade', 'traders'),
        'url' => ['index'],
    ];
    $this->params['breadcrumbs'][] = [
        'label' => Yii::t('trade', 'page_num', ['page' => $page]),
    ];
}

?>

<div class="box box-default">
    <div class="box-header with-border">
        <i class="fa fa-list"></i><h3 class="box-title"><?= $tableTitle ?></h3>

        <div class="box-tools pull-right">
            <div class="btn-group">
                <?= Html::a('<i class="fa fa-plus text-green"></i> ' . Yii::t('trade', 'add'), ['create'], ['class' => 'btn btn-default btn-sm']) ?>
            </div>
        </div>
    </div>

    <div class="box-body pad">

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                'trader_id',
                [
                    'label' => 'Название',
                    'attribute' => 'name',
                    'value' => function ($trader) {
                        return Html::a($trader->name, ['update',  'id' => $trader->getId()]);
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Трейд урл',
                    'attribute' => 'trade_url',
                    'value' => function ($trader) {
                        return Html::a($trader->trade_url, $trader->trade_url, ['target' => '_blank']);
                    },
                    'format' => 'raw',
                ],
                [
                    'label' => 'Форсы',
                    'attribute' => 'forces_tally',
                    'format' => 'integer',
                ],
                [
                    'label' => 'Вкл\выкл',
                    'attribute' => 'enabled',
                    'value' => function ($trader) {
                        if ($trader->isEnabled()) {
                            return Html::tag('small', Yii::t('trade', 'enabled'), ['class' => 'label bg-green']);
                        } else {
                            return Html::tag('small', Yii::t('trade', 'disabled'), ['class' => 'label bg-red']);
                        }
                    },
                    'format' => 'html',
                ],
                [
                    'class' => ActionColumn::class,
                    'options' => [
                        'width' => 75,
                    ]
                ],
            ],
        ]) ?>
    </div>
</div>
