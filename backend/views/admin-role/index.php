<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel app\services\UserService */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
?>
<p>
    <?= Html::a('新建', ['create'], ['class' => 'btn btn-success']) ?>
    <a class="btn btn-success _deleteAll" href="javascript:;" data-url="<?= Yii::$app->getUrlManager()->createUrl(['admin-role/delete-all']) ?>">删除所有</a>
</p>
<?php $form = ActiveForm::begin([
    'id' => 'from',
    'enableClientValidation' => false,
    'action' => 'javascript:;',//设置jq
]); ?>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
//        'filterModel' => $searchModel,
    'rowOptions'=>function($dataProvider){
        return ['id'=>'tr-'.$dataProvider->name];//,'class'=>'_tr'
    },
    'columns' => [
        [
            'class'=>'yii\grid\CheckboxColumn',
            'cssClass'=>'_check',//设置复选框的类名
        ],
        'name',
        [
            'label'=>'创建时间',
            'attribute'=>'create_at',
            'value'=>function($data){
                return date('Y-m-d H:i:s',$data->updated_at);
            }
        ],
        [
            'label'=>'更新时间',
            'attribute'=>'updated_at',
            'value'=>function($data){
                return date('Y-m-d H:i:s',$data->updated_at);
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'header' => '操作',
            'template' => "{update} {auth} {delete}",
            'buttons' => [
                'update' => function($url,$dataProvider){
                    return "<a href='".Yii::$app->getUrlManager()->createUrl(['/admin-role/update','name'=>$dataProvider->name])."' class='_delete' >编辑</a>";
                },
                'auth' =>function($url,$dataProvider){
                    return "<a href='".Yii::$app->getUrlManager()->createUrl(['/admin-role/auth','name'=>$dataProvider->name])."'>设权</a>";
                },
                'delete' => function($url,$dataProvider){
                    return "<a href='javascript:;' class='_delete' data-url='".Yii::$app->getUrlManager()->createUrl(['/admin-role/delete','name'=>$dataProvider->name])."'>删除</a>";
                },
            ]
        ],//操作类
    ],
    'emptyText'=>'当前没有会员',//没有数据提示语
    'emptyTextOptions'=>['style'=>'color:red;font-weight:bold'],//没有数据提示语的html样式
    'layout'=>"{items}\n{pager}",
    'showOnEmpty'=>false,
]);
?>
<?php ActiveForm::end(); ?>
<script type="text/javascript">
    $(function(){
        $("._delete").click(function () {
            var url = $(this).attr('data-url');
            $.post(url,{},function (res) {
                if(res.done == true){
                    alert('删除成功');
                    document.location.reload();
                }else{
                    alert(res.error);
                }},'json');
        });

        $("._deleteAll").click(function () {
            var url = $(this).attr('data-url');
            $.post(url,$("#from").serializeArray(),function (res) {
                if(res.done == true){
                    alert('删除成功');
                    document.location.reload();
                }else{
                    alert(res.error);
                }},'json');
        });
    });
</script>

