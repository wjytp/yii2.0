<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/12
 * Time: 12:46
 */
namespace backend\controllers;
use Yii;
class menu{
    public function get_menu(){
        /*$authManager = Yii::$app->authManager;
        $auth = $authManager->getPermissionsByRole(Yii::$app->user->identity->role);
        $authArr = array();
        foreach ($auth as $k => $v){
            $authArr[] = $v->name;
        }*/
        $admin_menu = Yii::$app->params['admin_menu'];
        $controllerName = Yii::$app->controller->id;
        $actionName = Yii::$app->controller->action->id;
        $breadCrumb = array();
        foreach ($admin_menu as $nodesKey => $nodes){
            foreach ($nodes['nodes'] as $controllersKey => $controllers){
                foreach ($controllers['controllers'] as $actionsKey => $actions){
                    foreach ($actions['actions'] as $key => $item){
                        if((strtolower($actionsKey) === strtolower($controllerName)) && (strtolower($key) === strtolower($actionName))){
                            $breadCrumb[0] = $nodes['name'];
                            $breadCrumb[1] = $controllers['name'];
                            $breadCrumb[2] = $actions['name'];
                            $breadCrumb[3] = $item['name'];
                            $admin_menu[$nodesKey]['nodes'][$controllersKey]['controllers'][$actionsKey]['check'] = true;
                            $currentUrl = $admin_menu[$nodesKey]['nodes'][$controllersKey]['controllers'][$actionsKey]['url'];
                            $currentNav = $nodesKey;
                            $currentNode = $controllersKey;
                        }
                    }
                }
            }
        }
        return array('admin_menu'=>$admin_menu,'breadCrumb'=>$breadCrumb,'currentNav'=>$currentNav,'currentNode'=>$currentNode,'currentUrl'=>$currentUrl);
    }
    public function get_role_auth(){
        $authManager = Yii::$app->authManager;
        $auth = $authManager->getPermissionsByRole(Yii::$app->user->identity->role);
        $authArr = array();
        foreach ($auth as $k => $v){
            $authArr[] = $v->name;
        }
        return $authArr;
    }
    public function get_menu_node($admin_menu){
        $controllerName = Yii::$app->controller->id;
        $actionName = Yii::$app->controller->action->id;
        $breadCrumb = array();
        foreach ($admin_menu as $nodesKey => $nodes){
            foreach ($nodes['nodes'] as $controllersKey => $controllers){
                foreach ($controllers['controllers'] as $actionsKey => $actions){
                    foreach ($actions['actions'] as $key => $item){
                        if((strtolower($actionsKey) === strtolower($controllerName)) && (strtolower($key) === strtolower($actionName))){
                            $breadCrumb[0] = $nodes['name'];
                            $breadCrumb[1] = $controllers['name'];
                            $breadCrumb[2] = $actions['name'];
                            $breadCrumb[3] = $item['name'];
                            $admin_menu[$nodesKey][$controllersKey][$actionsKey]['check'] = 1;
                            $currentNav = $nodesKey;
                            return array('breadCrumb'=>$breadCrumb,'currentNav'=>$currentNav,'currentUrl'=>str_replace('/','',strtolower($actions['url'])),'currentNode'=>$controllersKey);
                        }
                    }
                }
            }
        }
    }
}