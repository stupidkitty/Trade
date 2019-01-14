<?php
namespace SK\Module\TradeModule\Controller;

use Yii;
use yii\base\ViewContextInterface;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use RS\Component\Core\Settings\SettingsInterface;

/**
 * OutController implements the redirecto to trade action.
 */
class OutController extends Controller
{
    /**
     * Переопределяет дефолтный путь шаблонов модуля.
     * Путь задается в конфиге модуля, в компонентах приложения.
     *
     * @return string
     */
    public function getViewPath()
    {
        return $this->module->getViewPath();
    }
    
    /**
     * Send to trade action
     *
     * @return mixed
     */
    public function actionSend()
    {
        return $this->render('send');
    }
}
