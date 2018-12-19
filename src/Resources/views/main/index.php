<?php

use yii\web\View;
use yii\helpers\Url;
use yii\helpers\Html;

$pageTitleSuffix = '';

$this->title = Yii::t('trade', 'trade');
$this->params['subtitle'] = Yii::t('trade', 'overview');

$this->params['breadcrumbs'][] = $this->title;

?>

<div class="box box-default">
	<div class="box-body pad">
		Модуль трейда.
	</div>
</div>
