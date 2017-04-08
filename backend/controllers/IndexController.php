<?php
namespace backend\controllers;
use backend\controllers\BaseController;

class IndexController extends BaseController{
    public function actionIndex() {
        return $this->render('index');
    }
}