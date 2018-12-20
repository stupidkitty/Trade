<?php
namespace SK\Module\TradeModule\Form;

use yii\base\Model;
use SK\Module\TradeModule\Model\Trader;

class TraderForm extends Model
{
	public $name;
	public $trade_url;
	public $skim;
    public $forces_tally;
    public $enabled;

    private $trader;

    /**
     * Form constructor. Set attributes from AR model.
     *
     * @param Trader $trader
     * @param array $config
     */
    public function __construct(Trader $trader, $config = [])
    {
        parent::__construct($config);

        $this->trader = $trader;
        $this->setAttributes($trader->getAttributes());
    }

    /**
     * Form validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'trade_url'], 'required'],
            [['name', 'trade_url'], 'string'],
            [['skim', 'forces_tally'], 'integer'],
            [['enabled'], 'boolean'],
        ];
    }

    /**
     * Check form is valid.
     *
     * @return boolean
     */
    public function isValid()
    {
        return $this->validate();
    }

    /**
     * Set data to model.
     *
     * @return void
     */
    public function getData()
    {
        $this->trader->setAttributes($this->getAttributes());

        $currentDatetime = gmdate('Y-m-d H:i:s');

        $this->trader->updated_at = $currentDatetime;

        if ($this->trader->isNewRecord) {
            $this->trader->created_at = $currentDatetime;
        }

        return $this->trader;
    }
}
