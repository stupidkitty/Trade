<?php
namespace SK\Module\TradeModule\Admin;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use SK\Module\TradeModule\Model\Trader;
use SK\Module\TradeModule\Form\TraderForm;

/**
 * TraderController implements the CRUD actions for Trader model.
 */
class TraderController extends Controller
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
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Trader models.
     *
     * @return mixed
     */
    public function actionIndex($page = 1)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Trader::find(),
            'sort' => [
                'defaultOrder' => [
                    'trader_id' => SORT_DESC,
                ],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'page' => $page,
        ]);
    }

    /**
     * Displays a single Trader model.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        $trader = $this->findById($id);

        return $this->render('view', [
            'trader' => $trader,
        ]);
    }

    /**
     * Creates a new Trader model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $trader = new Trader;
        $form = new TraderForm($trader);

        if ($form->load(Yii::$app->request->post()) && $form->isValid()) {
            $trader = $form->getData();
            $trader->save();

            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'form' => $form,
            ]);
        }
    }

    /**
     * Updates an existing Trader model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $trader = $this->findById($id);
        $form = new TraderForm($trader);

        if ($form->load(Yii::$app->request->post()) && $form->isValid()) {
            $trader = $form->getData();
            $trader->save();

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'form' => $form,
                'trader' => $trader,
            ]);
        }
    }

    /**
     * Deletes an existing Trader model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $trader = $this->findById($id);

        $trader->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Trader model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return Trader The loaded model.
     * @throws NotFoundHttpException If the model cannot be found.
     */
    protected function findById($id)
    {
        $trader = Trader::findOne($id);

        if (null === $trader) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        return $trader;
    }
}
