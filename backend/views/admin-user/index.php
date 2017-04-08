<?php
use yii\widgets\LinkPager;
/*use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use backend\models\User;
$dataProvider = new ActiveDataProvider([
    'query' => User::find(),
    'pagination' => [
        'pageSize' => 20,
    ],
]);
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        [
            'class' => 'yii\grid\CheckboxColumn',
            // 你可以在这配置更多的属性
        ],
        ['class' => 'yii\grid\SerialColumn'],
        // 数据提供者中所含数据所定义的简单的列
        // 使用的是模型的列的数据
        'id',
        'username',
    ],

]);
exit();*/
?>
<table class="table table-bordered">
    <thead>
    <tr>
        <th style="width: 30px;"><input class="select-on-check-all" name="selection_all" value="1" type="checkbox"></th>
        <th>编号</th>
        <th>用户名</th>
        <th>邮箱</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($user as $key => $value):?>
        <tr>
            <td><input name="selection[]" value="<?= $value['id'] ?>" type="checkbox"></td>
            <td><?= $value['id'] ?></td>
            <td><?= $value['username'] ?></td>
            <td><?= $value['email'] ?></td>
            <td>
                <a href="<?= Yii::$app->urlManager->createUrl(['admin-user/edit','id'=>$value['id']]) ?>">编辑</a>
                <a onclick="">删除</a>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
<div class="text-center">
    <?= LinkPager::widget(['pagination' => $pagination,]) ?>
</div>
<script>
    $(function () {
        $(".select-on-check-all").click(function () {
            $("input[name='selection[]']").attr('checked',this.checked);
        });
    });
</script>



