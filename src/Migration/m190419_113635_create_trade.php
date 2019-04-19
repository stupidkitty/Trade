<?php

use yii\db\Migration;

/**
 * Class m190419_113635_create_trade
 */
class m190419_113635_create_trade extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        /**
         * Create `traders` table
         */
        $this->createTable('traders', [
            'trader_id' => 'int(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY',
            'name' => 'varchar(255) COLLATE utf8_general_ci NOT NULL DEFAULT \'\'',
            'trade_url' => 'varchar(255) COLLATE utf8_general_ci NOT NULL DEFAULT \'\'',
            'forces_tally' => 'int(10) UNSIGNED NOT NULL DEFAULT 0',
            'enabled' => 'tinyint(3) UNSIGNED NOT NULL DEFAULT 0',
            'created_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
            'updated_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ], $tableOptions);

        $this->createIndex('enabled', 'traders', ['enabled', 'forces_tally']);

        /**
         * Create `taders_sent` table
         */
        $this->createTable('taders_sent', [
            'trader_id' => 'int(10) UNSIGNED NOT NULL DEFAULT 0',
            'ip_addr' => 'varbinary(16) DEFAULT NULL',
            'created_at' => 'timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP',
        ], $tableOptions);

        $this->createIndex('trader_id', 'taders_sent', 'trader_id');
        $this->createIndex('ip_addr', 'taders_sent', ['ip_addr', 'created_at']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190419_113635_create_trade cannot be reverted.\n";

        return false;
    }
}
