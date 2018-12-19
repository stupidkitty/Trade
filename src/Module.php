<?php
namespace RS\Module\TradeModule;

use Yii;
use yii\base\Module as BaseModule;
use yii\i18n\PhpMessageSource;
use yii\console\Application as ConsoleApplication;
use yii\web\Application as WebApplication;

/**
 * This is the main module class of the trade extension.
 */
class Module extends BaseModule
{
    /**
     * @var string Module cotrollers namespace.
     */
    public $controllerNamespace = 'RS\Module\TradeModule\Controller';

    /**
     * @var string Default route.
     */
    public $defaultRoute = 'main/index';

    /**
     * @inheritdoc
     */
    public function __construct($id, $parent = null, $config = [])
    {
        // default templates path
        $this->setViewPath(__DIR__ . '/Resources/views');

        parent::__construct ($id, $parent, $config);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if (Yii::$app instanceof ConsoleApplication) {
            $this->controllerNamespace = 'RS\Module\TradeModule\Command';
            $this->defaultRoute = 'run/index';
        }

        //translations
        if (!isset(Yii::$app->get('i18n')->translations['trade'])) {
            Yii::$app->get('i18n')->translations['trade'] = [
                'class' => PhpMessageSource::class,
                'basePath' => __DIR__ . '/Resources/i18n',
                'sourceLanguage' => 'en-US',
            ];
        }
    }
}
