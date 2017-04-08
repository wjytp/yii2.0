<?php
namespace backend\controllers;
use backend\controllers\BaseController;
use backend\services\AdminService;
use Yii;
use backend\services\UserService;
use yii\base\Exception;
use yii\helpers\Json;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class AdminController extends BaseController
{
    
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

        $searchModel = new AdminService();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider['dataProvider'],
        ]);
    }
  
    public function actionCreate()
    {
        $roles = Yii::$app->authManager->getRoles();
        $model = new AdminService();
//        $model->scenario = 'register';
        if ($model->load(Yii::$app->request->post()) && $model->create()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
                'roles' => $roles
            ]);
        }
    }
    
    public function actionUpdate($id)
    {
        $roles = Yii::$app->authManager->getRoles();
        $model = AdminService::findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->updateById($id)) {
            return $this->redirect(['index']);
        } else {
            $roles = Yii::$app->authManager->getRoles();
            return $this->render('update', [
                'model' => $model,
                'roles' => $roles
            ]);
        }
    }
    
    public function actionDelete($id)
    {
        try{
            AdminService::deleteOneById($id);
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
            AdminService::deleteAllByIds($ids);
            echo Json::encode(['done' => true]);
        } catch (\Exception $e){
            echo Json::encode(['done' => false,'error'=>$e->getMessage()]);
        }
    }
    
}
