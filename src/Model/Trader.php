<?php
namespace SK\TradeModule\Model;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "traders".
 *
 * @property integer $trader_id
 * @property string $name
 * @property string $trade_url
 * @property integer $forces_tally
 * @property boolean $enabled
 * @property string $updated_at
 * @property string $created_at
 */
class Trader extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'traders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'trade_url'], 'string'],
            [['forces_tally'], 'integer'],
            [['enabled'], 'boolean'],
            [['updated_at', 'created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->trader_id;
    }

    public function decreaseForcesTally()
    {
        if ($this->forces_tally <= 0) {
            return;
        }

        $sql = "
            UPDATE `traders`
               SET `forces_tally` = IF(`forces_tally` > 0, `forces_tally` - 1, 0)
             WHERE `trader_id` = :trader_id
        ";

        $command = static::getDb()->createCommand($sql);
        $command->bindValue(':trader_id', $this->getId());

        if ($command->execute()) {
            $this->forces_tally -= 1;
        }
    }
}
