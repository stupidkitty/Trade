<?php
namespace SK\TradeModule\Controller;

use Yii;
use yii\web\Request;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use SK\TradeModule\Helper\TradeUrl;
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
        $request = Yii::$container->get(Request::class);
        $settings = Yii::$container->get(SettingsInterface::class);
        $getVars = TradeUrl::getRequestVars();

        if (isset($getVars['skim'])) {
            $skim = (int) $getVars['skim'];
        } else {
            $skim = (int) $settings->get('skim', 90, 'trade');
        }

        // Если выпало на контент и урл для контента задан редиректим на контент.
        if ($this->isSkim($skim) && !empty($getVars['url'])) {
            return $this->redirect($getVars['url']);
        }

        $trader = $this->getTrader();

        $tradeUrl = '';
        $redirectUrl = '';
        
        if (empty($getVars['url']) && null === $trader) {
            // если оба пустые, отправляем на слив куда-то.
            $this->redirect($defaultUrl);
        } elseif (null === $trader) {
            // если нету трейда, отправляем на контент.
            $this->redirect($getVars['url']);
        }

        // дальше обрабатываем трейд.
        if ($trader['forces_tally'] > 0) {
            $this->decreaseTraderForcesTally($trader['trader_id']);
        }

        $this->sentTo($trader['trader_id']);

        $this->redirect($trader['trader_url']);
        
        return $this->render('send');
    }

    /**
     * Вычисляет шанс показа контента (skim)
     *
     * @param integer $skim
     * @return boolean
     */
    private function isSkim($skim = 100)
    {
        $skim = (int) $skim;

        if (100 === $skim) {
            return true;
        }

        $randValue = \rand(0, 10000); // random_int mt_rand rand

        $randValue = (int) \ceil($randValue / 100);

        if ($randValue <= $skim) {
            return true;
        }

        return false;
    }
}
