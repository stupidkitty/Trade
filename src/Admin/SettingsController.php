<?php
namespace SK\Module\TradeModule\Admin;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use RS\Component\Core\Settings\SettingsInterface;
use SK\Module\TradeModule\Form\SettingsForm;

/**
 * SettingsController
 */
class SettingsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
           'access' => [
               'class' => AccessControl::class,
               'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * List base Settings and save it.
     * @return mixed
     */
    public function actionIndex()
    {
        $settings = Yii::$container->get(SettingsInterface::class);

        $form = new SettingsForm($settings->getAll('trade'));

        if ($form->load(Yii::$app->request->post()) && $form->isValid()) {
            foreach ($form->getAttributes() as $name => $value) {
                $settings->set($name, $value, 'trade');
            }

            Yii::$app->session->setFlash('info', 'Настройки сохранены');
        }

        return $this->render('index', [
            'form' => $form,
        ]);
    }
}
