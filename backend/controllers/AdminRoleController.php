<?php

namespace backend\controllers;
use backend\services\AdminRoleService;
use Yii;
use yii\base\Exception;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\rbac\Item;

/**
 * UserController implements the CRUD actions for User model.
 */
class AdminRoleController extends Controller
{
    public $type = Item::TYPE_ROLE;
    /*public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                    'delete-all' => ['POST']
                ],
            ],
        ];
    }*/

    public function actionIndex()
    {
        $searchModel = new AdminRoleService();
        $searchModel->type = $this->type;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new AdminRoleService();
        $model->type = $this->type;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($name) {
        $model = new AdminRoleService();
        $model = $model->findModel($name);
        if($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionAuth($name)
    {
        $model = AdminRoleService::findModel($name);
        if (Yii::$app->request->isPost && $model->updateByName($name)) {
            return $this->redirect(['index']);
        } else {
            $authRules = Yii::$app->authManager->getChildren($name);
            $authRules = array_keys($authRules);
            return $this->render('auth', [
                'model' => $model,
                'authRules'=>$authRules,
                'admin_menu' => Yii::$app->params['admin_menu']
            ]);
        }
    }

    public function actionDelete($name)
    {
        try{
            AdminRoleService::deleteOneById($name);
            echo Json::encode(['done' => true]);
        } catch (\Exception $e){
            echo Json::encode(['done' => false,'error'=>$e->getMessage()]);
        }
    }

    public function actionDeleteAll()
    {
        try{
            $ids = Yii::$app->request->post('selection');
            if(empty($ids)){
                throw new Exception('至少要选择一个待删除的会员');
            }
            AdminRoleService::deleteAllByIds($ids);
            echo Json::encode(['done' => true]);
        } catch (\Exception $e){
            echo Json::encode(['done' => false,'error'=>$e->getMessage()]);
        }
    }

}
