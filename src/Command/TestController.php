<?php
namespace SK\TradeModule\Command;

use Yii;
use yii\console\Controller;
use SK\TradeModule\Out;


class TestController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
        set_time_limit(600);

        $out = new Out;

        $out->out();
        /*$toTrade = 0;
        $toSkim = 0;

        for ($i = 0; $i < 100; $i++) {
            if ($out->isSkim(50)) {
                $toSkim ++;
            } else {
                $toTrade ++;
            }
        }*/

        //dump("To trade: {$toTrade}", "To skim: {$toSkim}");
    }

}
