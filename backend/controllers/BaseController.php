<?php
namespace backend\controllers;
use backend\components\AccessControl;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

use backend\models\LoginForm;
class BaseController extends Controller{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    ['actions' => [
                        'delete' => ['POST'],
                        'delete-all' => ['POST']
                    ],
                    ]

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post','get'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->renderPartial('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        
        return $this->goHome();
    }

    public function beforeAction($action)
    {
//        if(isset(Yii::$app->user->identity->id)){
//            $check = Yii::$app->authManager->checkAccess(Yii::$app->user->identity->id,strtolower(Yii::$app->controller->id.'/'.Yii::$app->controller->action->id));
//            if(!$check){
//                var_dump('权限不足');die;
//            }
//        }
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }
}