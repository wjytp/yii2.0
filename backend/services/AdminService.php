<?php

namespace backend\services;
use backend\models\Admin;
use Yii;
use yii\data\ActiveDataProvider;

/**
 * UserService represents the model behind the search form about `app\models\User`.
 */
class AdminService extends Admin
{
    public $username;
    public $password;
    public $email;
    public $role;
    
    public function search($params)
    {
        $query = Admin::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination'=>[
                'pageSize' => 2,//$pagination->getPageSize()
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return ['dataProvider'=>$dataProvider];//,'pagination'=>$pagination
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'role', $this->role]);

        return ['dataProvider'=>$dataProvider];//,'pagination'=>$pagination
    }
    public function create()
    {
        // 调用validate方法对表单数据进行验证，验证规则参考上面的rules方法
        if (!$this->validate()) {
            return null;
        }

        // 实现数据入库操作
        $user = new Admin();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->role = $this->role;
        
        // 设置密码，密码肯定要加密，暂时我们还没有实现，看下面我们有实现的代码
        $user->setPassword($this->password);

        // 生成 "remember me" 认证key
        $user->generateAuthKey();
        // save(false)的意思是：不调用UserBackend的rules再做校验并实现数据入库操作
        // 这里这个false如果不加，save底层会调用UserBackend的rules方法再对数据进行一次校验，因为我们上面已经调用Signup的rules校验过了，这里就没必要在用UserBackend的rules校验了
        if($user->save(false)){
            if(!$this->setAdminRole(Yii::$app->db->getLastInsertID(),$this->role)){
                return false;
            }
        };
        return true;
    }
    public function deleteAllByIds($ids)
    {
        $userList = Admin::find()->where(['in','id',$ids])->all();
        foreach ($userList as $user){
            $user->delete();
        }
        return true;
    }
    public function deleteOneById($id){
        $model = Admin::findOne($id);
        if($model === null){
            throw new NotFoundHttpException('会员不存在！');
        }
        $model->delete();
        return true;
    }
    public function findModel($id)
    {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
