<?php
namespace SK\Module\TradeModule\Helper;

class LinkHelper
{
    public static function create($url, array $options = [])
    {
        
    }

    public static function parseUri()
    {
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