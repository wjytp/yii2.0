<?php
use yii\widgets\ActiveForm;
?>
<style>
    .w40{
        width: 240px;
    }
</style>


<form role="form" action="<?= Yii::$app->urlManager->createUrl(['admin-user/edit'])?>" method="post">
    <div class="form-group">
        <label for="name">用户名</label>
        <input type="text" class="form-control w40" id="name"  name="username" value="<?= $user->username ?>" placeholder="请输入名称">
    </div>
    <div class="form-group">
        <label for="email">邮箱</label>
        <input type="text" class="form-control w40" id="email"  name="email" value="<?= $user->email ?>" placeholder="请输入名称">
    </div>
    <input type="hidden" name="id" value="<?= $user->id ?>">
    <input type="hidden" name="ok" value="ok">
    <input type="hidden" name="_csrf-backend" value="<?= Yii::$app->request->csrfToken ?>">
    <button type="submit" class="btn btn-default">提交</button>
</form>


