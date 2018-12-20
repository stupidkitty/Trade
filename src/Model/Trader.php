<?php
namespace SK\Module\TradeModule\Model;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "traders".
 *
 * @property integer $trader_id
 * @property string $name
 * @property string $trade_url
 * @property integer $skim
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
            [['skim', 'forces_tally'], 'integer'],
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
}
