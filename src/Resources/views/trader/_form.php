<?php

use yii\widgets\ActiveForm;

?>

<?php $activeForm = ActiveForm::begin([
    'id' => 'trader-form',
]) ?>

<?= $activeForm->field($form, 'name')->textInput() ?>

<?= $activeForm->field($form, 'trade_url')->textInput() ?>

<?= $activeForm->field($form, 'skim')->textInput() ?>

<?= $activeForm->field($form, 'forces_tally')->textInput() ?>

<?= $activeForm->field($form, 'enabled')->checkbox() ?>

<?php ActiveForm::end() ?>
