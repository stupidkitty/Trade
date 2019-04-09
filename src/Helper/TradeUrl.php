<?php
namespace SK\TradeModule\Helper;

class TradeUrl
{
    public static function createUrl($url, array $options = [])
    {
        
    }

    public static function parseRequest()
    {
        $request = Yii::$app->getRequest();
        $queryParams = [];
        if (!empty($_SERVER['QUERY_STRING'])) {
            \parse_str($_SERVER['QUERY_STRING'], $queryParams);
        }

        if (isset($queryParams['ps'])) {
            $decodedJson = \base64_decode($queryParams['ps']);
            $queryParams = \json_decode($decodedJson, true);
        }

        return  $queryParams;
    }
}