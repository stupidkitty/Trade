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

    private $db;

    public function __construct()
    {
        $this->db = new \PDO('mysql:dbname=rs_lc;host=127.0.0.1', 'test', 'testtest');
    }

    public function run()
    {
        $getVars = $this->parseUri();

        // Если выпало на контент и урл для контента задан редиректим на контент.
        if ($this->isSkim(0) && !empty($getVars['url'])) {
            $this->redirect($getVars['url']);
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

    // /out.php?ps=eyJ1cmwiOiJodHRwOlwvXC90ZXN0LmNvbVwvMTIzLmh0bWwiLCJza2ltIjo5MH0=
    public function parseUri()
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

    /**
     * Подбирает трейдера в таблице. Шлет только уникальные.
     *
     * @return array|null
     */
    private function getTrader()
    {
        $stmt = $this->db->prepare('
            SELECT `t`.`trader_id`, `t`.`trade_url`, `t`.`forces_tally` 
            FROM `traders` AS `t`
            LEFT JOIN (
                SELECT DISTINCT `trader_id`
                FROM `taders_sent`
                WHERE `ip_addr`=:ip_addr AND `created_at` > (NOW() - INTERVAL 1 MINUTE)
            ) AS `ts` ON (`t`.`trader_id` = `ts`.`trader_id`)
            WHERE `ts`.`trader_id` IS NULL AND `t`.`enabled` = 1
            ORDER BY `forces_tally` DESC
            LIMIT 1
        ');
        $stmt->execute([':ip_addr' => $this->getUserIp()]);

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        if (empty($row)) {
            return null;
        }
            
        $trader_id = (int) $row['trader_id'];
        $forces_tally = (int) $row['forces_tally'];
        
        $trader = [
            'trader_id' => $trader_id,
            'trade_url' => $row['trade_url'],
            'forces_tally' => $forces_tally,
        ];

        return $trader;
    }

    private function decreaseTraderForcesTally($id)
    {
        $stmt = $this->db->prepare('
            UPDATE `traders`
               SET `forces_tally` = IF(`forces_tally` > 0, `forces_tally` - 1, 0)
             WHERE `trader_id` = :trader_id
        ');
        $stmt->execute([':trader_id' => $id]);
    }

    public function sentTo($id)
    {
        $stmt = $this->db->prepare('
            INSERT INTO `taders_sent` (`trader_id`, `ip_addr`, `created_at`)
            VALUES (:trader_id, :ip_addr, :created_at)
        ');
        $stmt->execute([':trader_id' => $id, ':ip_addr' => $this->getUserIp(), ':created_at' => \gmdate('Y-m-d H:i:s')]);
    }

    private function getUserIp()
    {
        return isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : null;
    }
}
