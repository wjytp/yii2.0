<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\rbac\Item;

/**
 * This is the model class for table "auth_item".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $authItemChildren
 * @property AuthItemChild[] $authItemChildren0
 * @property AuthItem[] $children
 * @property AuthItem[] $parents
 */
class AuthItem extends Model{

    public $name;
    public $type;
    public $description;
    public $ruleName;
//    public $created_at;
//    public $updated_at;
    public $data;

    private $_item;

    public function __construct($item = null) {
        $this->_item = $item;
        if($item !== null) {
            $this->name = $item->name;
            $this->type = $item->type;
            $this->description = $item->description;
            $this->ruleName = $item->ruleName;
            $this->data = $item->data === null ? null : Json::encode($item->data);
        }
    }

    //自动设置 created_at updated_at
    /*public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }*/

    public function rules() {
        return [
            [['name'], 'required'],
            ['description', 'filter', 'filter' => function($value) {
                return Html::encode($value);
            }],
            [['type'], 'integer'],
            [['description', 'ruleName'], 'safe'],
        ];
    }

    public function attributeLabels() {
        return [
            'name' => '角色名称',
            'description' => '描述',
            'created_at' => '添加时间',
            'updated_at' => '更新时间',
            'type' => 'Type',
            'ruleName' => 'Rule Name',
            'data' => 'Data',
        ];
    }

    //检测记录是否为空
    public function getIsNewRecord() {
        return $this->_item === null;
    }

    public function save() {
        if(!$this->validate()) return false;
        $authManager = Yii::$app->authManager;
        if($this->_item !== null) {
            $isNew = false;
            $oldName = $this->_item->name;
        } else {
            $isNew = true;
            $this->_item = ($this->type == Item::TYPE_ROLE) ? $authManager->createRole($this->name) : $authManager->createPermission($this->name);
        }
        $this->_item->name = $this->name;
        $this->_item->type = $this->type;
        $this->_item->description = $this->description;
        if($this->ruleName) $this->_item->ruleName = $this->ruleName;
        //$this->_item->data = $this->data === null ? null : Json::ecode($this->data);
        if($isNew) $authManager->add($this->_item);
        else $authManager->update($oldName, $this->_item);
        //Helper::invalidate();
        return true;
    }

    public function getItem() {
        return $this->_item;
    }

    public function updateByName($name){
        $authManager = Yii::$app->authManager;
        $rules = Yii::$app->request->post('node', []);
        if(!$role = $authManager->getRole($name)) {
            Yii::$app->session->setFlash('error', '角色不存在');
        }
        //删除角色所有child
        $authManager->removeChildren($role);
        foreach ($rules as $rule) {
            //auth_rule表
            $ruleModel = new AuthRule();
            $ruleModel->name = $rule;
            $ruleModel->save();
            //auth_item表
            $itemModel = new AuthItem($authManager->getPermission($rule));
            $itemModel->name = $rule;
            $itemModel->type = Item::TYPE_PERMISSION;
            $itemModel->ruleName = $rule;
            $itemModel->save();
            //auth_item_child表
            if(!$authManager->hasChild($role, $itemModel)) {
                $authManager->addChild($role, $itemModel);
            }
        }
        Yii::$app->session->setFlash('success', '操作成功');
        return true;
    }

}
