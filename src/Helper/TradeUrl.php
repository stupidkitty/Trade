<?php
namespace SK\TradeModule\Helper;

use Yii;
use yii\helpers\Url;

class TradeUrl
{
    /**
     * @var \yii\web\UrlManager URL manager to use for creating URLs
     */
    public static $urlManager;
    
    /**
     * Creates a URL based on the given parameters.
     *
     * @param array|string $url the parameter to be used to generate a valid URL
     * @param array $tradeParams options for encoded trade params
     * @param bool|string $scheme the URI scheme to use in the generated URL:
     *
     * - `false` (default): generating a relative URL.
     * - `true`: returning an absolute base URL whose scheme is the same as that in [[\yii\web\UrlManager::$hostInfo]].
     * - string: generating an absolute URL with the specified scheme (either `http`, `https` or empty string
     *   for protocol-relative URL).
     * 
     * @return string the generated URL
     */
    public static function createUrl($url, array $tradeParams = [], $scheme = false)
    {
        $tradeParam = [];
        if (!empty($tradeParams)) {
            $jsonParams = \json_encode($tradeParams);
            $tradeParam = ['ps' => \base64_encode($jsonParams)];
        }

        if (is_array($url)) {
            $url = array_merge($url, $tradeParam);
        }

        return Url::to($url, $scheme);
    }

    // /out/?ps=eyJ1cmwiOiJodHRwOlwvXC90ZXN0LmNvbVwvMTIzLmh0bWwiLCJza2ltIjo5MH0=
    public static function getRequestVars()
    {
        $request = Yii::$app->getRequest();
        $requestParams = $request->get();

        if (isset($requestParams['ps'])) {
            $jsonParams = \base64_decode($requestParams['ps']);
            $jsonVars = \json_decode($jsonParams, true);

            unset($requestParams['ps']);
            $requestParams = array_merge($requestParams, $jsonVars);
        }

        return $requestParams;
    }

    /**
     * @return \yii\web\UrlManager URL manager used to create URLs
     */
    protected static function getUrlManager()
    {
        return static::$urlManager ?: Yii::$app->getUrlManager();
    }
}