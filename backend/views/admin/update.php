<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Update User: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?php $form=ActiveForm::begin(
    [
        'action'=> Yii::$app->getUrlManager()->createUrl(['admin/update','id'=>$model->id]),
        'method'=>'post',
        'options'=>['name'=>'form'],
    ]
)?>

<?=$form->field($model,'username',[
    'template' => '{label} <div class="row"><div class="col-sm-4">{input}{error}{hint}</div></div>',
])->input(['value'=>$model->username])?>

<?=$form->field($model,'email',[
    'template' => '{label} <div class="row"><div class="col-sm-4">{input}{error}{hint}</div></div>',
])->input(['value'=>$model->email])?>

<?= Html::activeDropDownList($model, 'role', ArrayHelper::map($roles,'name', 'name'), ['class' => 'form-control','style'=>'margin-bottom:20px;margin-top:10px;width: 33.33333333%;']) ?>

<?=Html::submitButton('提交')?>

<?php ActiveForm::end()?>

