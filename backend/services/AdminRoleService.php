<?php

namespace backend\services;
use backend\models\AuthItem;
use Yii;
use yii\data\ArrayDataProvider;
use yii\rbac\Item;

/**
 * UserService represents the model behind the search form about `app\models\User`.
 */
class AdminRoleService extends AuthItem
{
    public $name;
    public $description;
    public $type = Item::TYPE_ROLE;

    public function search($params)
    {
        /* @var \yii\rbac\Manager $authManager */
        $authManager = Yii::$app->authManager;
        if ($this->type == Item::TYPE_ROLE) {
            $items = $authManager->getRoles();
        } else {
            $items = array_filter($authManager->getPermissions(), function($item) {
                return $this->type == Item::TYPE_PERMISSION xor strncmp($item->name, '/', 1) === 0;
            });
        }
        $this->load($params);
        if ($this->validate()) {
            $search = mb_strtolower(trim($this->name));
            $desc = mb_strtolower(trim($this->description));
            $ruleName = $this->ruleName;
            foreach ($items as $name => $item) {
                $f = (empty($search) || mb_strpos(mb_strtolower($item->name), $search) !== false) &&
                    (empty($desc) || mb_strpos(mb_strtolower($item->description), $desc) !== false) &&
                    (empty($ruleName) || $item->ruleName == $ruleName);
                if (!$f) {
                    unset($items[$name]);
                }
            }
        }
        return new ArrayDataProvider([
            'allModels' => $items,
        ]);
        /*$query = AuthItem::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>[
                'pageSize' => 2,//$pagination->getPageSize()
            ]
        ]);
        $this->load($params);
        $query->andFilterWhere([
            'type' => 1,
        ]);
        if (!$this->validate()) {
            return ['dataProvider'=>$dataProvider];//,'pagination'=>$pagination
        }
        return ['dataProvider'=>$dataProvider];//,'pagination'=>$pagination*/
    }
    public function create()
    {
        // 调用validate方法对表单数据进行验证，验证规则参考上面的rules方法
        if (!$this->validate()) {
            return null;
        }

        // 实现数据入库操作
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;

        // 设置密码，密码肯定要加密，暂时我们还没有实现，看下面我们有实现的代码
        $user->setPassword($this->password);

        // 生成 "remember me" 认证key
        $user->generateAuthKey();

        // save(false)的意思是：不调用UserBackend的rules再做校验并实现数据入库操作
        // 这里这个false如果不加，save底层会调用UserBackend的rules方法再对数据进行一次校验，因为我们上面已经调用Signup的rules校验过了，这里就没必要在用UserBackend的rules校验了
        return $user->save(false);
    }
    public function deleteAllByIds($ids)
    {
        foreach ($ids as $name){
            $model = AdminRoleService::findModel($name);
            Yii::$app->authManager->remove($model->item);
        }
        return true;
    }
    public function deleteOneById($id){
        $model = AdminRoleService::findModel($id);
        Yii::$app->authManager->remove($model->item);
        return true;
    }
    public function findModel($id) {
        $authManager = Yii::$app->authManager;
        $item = $this->type === Item::TYPE_ROLE ? $authManager->getRole($id) : $authManager->getPermission($id);
        if($item) return new AuthItem($item);
        else throw new NotFoundHttpException("The requested page does not exist.");
    }
}