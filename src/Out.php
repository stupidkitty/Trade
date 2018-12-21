<?php
namespace SK\Module\TradeModule;

/**
 * Cj out class
 */
class Out
{
    private $skim = 90; // default skim
    private $nrSkim = 100; // noref skim
    private $firstClickSkim = 100; // first click skim



    public function run()
    {
        $url = "http://test.com/";
        $getVars = $this->parseUri();


        // Если выпало на контент и урл для контента задан редиректим на контент.
        if ($this->isSkim(90) && !empty($getVars['url'])) {
            $this->redirect($getVars['url']);
        }

        $tradeUrl = '';
        $redirectUrl = '';
        if (empty($getVars['url']) && empty($tradeUrl)) {
            // если оба пустые, отправляем на слив куда-то.
            $redirectUrl = $defaultUrl;
        } elseif (empty($tradeUrl)) {
            // если нету трейда, отправляем на контент.
            $redirectUrl = $getVars['url'];
        } elseif (empty($getVars['url'])) { // Ситуация когда нет трейдеров и нет урла на контент. Куда слать?!
            // если нету урла в гетах, отправляем на трейд.
            $redirectUrl = $tradeUrl;
        }

        $this->redirect($redirectUrl);
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

        $randValue = \random_int(0, 10000); // random_int mt_rand rand

        $randValue = (int) \ceil($randValue / 100);

        if ($randValue <= $skim) {
            return true;
        }

        return false;
    }

    /**
     * Redirect to new url.
     *
     * @param string $url
     * @param boolean $replace
     * @param integer $code
     * @return void
     */
    private function redirect($url, $replace = true, $code = 302)
    {
        \header("Location: $url", $replace, $code);
        exit;
    }

    public function parseUri()
    {
        //$currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";

        $queryParams = [];
        if (!empty($_SERVER['QUERY_STRING'])) {
            \parse_str($_SERVER['QUERY_STRING'], $queryParams);
        }

        if (isset($queryParams['ps'])) {
            $decodedJson = \base64_decode($queryParams['ps']);
            //$jsonParams = \json_decode($base64Params, true);
            //$queryParams = \array_merge($queryParams, $jsonParams);
            $queryParams = \json_decode( $decodedJson, true);

           // unset($queryParams['ps']);
        }

        /*$params = [
            'url' => 'http://test.com/123.html',
            'skim' => 90,
        ];

        $json = \json_encode($params);
        $base64 = \base64_encode($json);*/


        //dump($_SERVER['REQUEST_URI'], $_SERVER, $queryParams, $base64);
        return  $queryParams;
    }
}
