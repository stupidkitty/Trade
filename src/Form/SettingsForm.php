<?php
namespace SK\TradeModule\Form;

use yii\base\Model;

class SettingsForm extends Model
{
    /**
     * @var string Дефолтный урл для слива "плохого" трафика или ошибок.
     */
    public $default_out_url;
    
    /**
     * @var integer Ским.
     */
    public $skim;
    
    /**
     * @var integer Ским для норефов.
     */
    public $noref_skim;
 
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['skim', 'noref_skim'], 'integer', 'integerOnly' => true, 'min' => 0, 'max' => 100],
            [['default_out_url'], 'string'],
            [['default_out_url'], 'trim'],

            // defaults
            [['skim'], 'default', 'value' => 90],
            [['noref_skim'], 'default', 'value' => 100],
            [['default_out_url'], 'default', 'value' => 'https://google.com/'],
        ];
    }

    /**
     * Валидирует форму настроек
     *
     * @return bool
     */
    public function isValid()
    {
        return $this->validate();
    }
}
