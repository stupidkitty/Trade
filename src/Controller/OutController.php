<?php
namespace SK\TradeModule\Controller;

use Yii;
use yii\web\Request;
use yii\db\Expression;
use yii\web\Controller;
use SK\TradeModule\Model\Trader;
use SK\TradeModule\Helper\TradeUrl;
use SK\TradeModule\Model\TraderSent;
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
            return $this->redirect($settings->get('default_out_url', '', 'trade'));
        } elseif (null === $trader) {
            // если нету трейда, отправляем на контент.
            return $this->redirect($getVars['url']);
        }

        // дальше обрабатываем трейд.
        $trader->decreaseForcesTally();
        $this->registerSending($trader, $request);

        return $this->redirect($trader->trade_url);
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

    /**
     * Подбирает трейдера в таблице. Шлет только уникальные.
     *
     * @return array|null
     */
    private function getTrader()
    {
        $request = Yii::$container->get(Request::class);

        $sendedSubQuery = TraderSent::find()
            ->distinct('trader_id')
            ->where(['ip_addr' => inet_pton($request->getUserIp())])
            ->andWhere(['>', 'created_at', new Expression('NOW() - INTERVAL 1 MINUTE')]);
        
        $traderQuery = Trader::find()
            ->alias('t')
            ->leftJoin(['ts' => $sendedSubQuery], 't.trader_id = ts.trader_id')
            ->where(['ts.trader_id' => null, 't.enabled' => 1])
            ->orderBy(['t.forces_tally' => SORT_DESC, new Expression('RAND()')])
            ->limit(1);

        return $traderQuery->one();
    }

    public function registerSending($trader)
    {
        $request = Yii::$container->get(Request::class);

        $traderSent = new TraderSent([
            'trader_id' => $trader->getId(),
            'ip_addr' => $request->getUserIp(),
            'created_at' => \gmdate('Y-m-d H:i:s')
        ]);

        $traderSent->save();
    }

    /**
     * Подзапрос из телеги
     * 
        SELECT `t`.`trader_id`, `t`.`trade_url`, `t`.`forces_tally` 
        FROM `traders` AS `t`
        WHERE `t`.`enabled` = 1
        and not exists(
            SELECT *
            FROM `taders_sent` as `ts`
            WHERE `ts`.`trader_id` = `t`.`trader_id`
        and  `ts`.`ip_addr` = :ip_addr 
        AND `ts`.`created_at` > (NOW() - INTERVAL 30 MINUTES)
        )
        ORDER BY `forces_tally` DESC
        LIMIT 1
     */
}
