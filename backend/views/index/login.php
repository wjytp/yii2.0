<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'Bootstrap 实例 ';
?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="stylesheet" href="https://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        .btn-default{
            font-size: 20px;
            color: #fff;
            background: #35b415;
            border-radius: 3px;
            text-align: center;
            background-image: linear-gradient(to bottom, #32c718, #37a712);
            display: inline-block;
            border: 1px solid #329e0e;
            width: 100%;
            line-height: 40px;
            margin-top: 25px;
            height: auto;
        }
        .mt25{
            margin-top: 25px;
        }
    </style>
</head>
<body>
<div>
    <div class="col-lg-12 text-center" style="margin-left: auto;margin-right: auto;">
        <div class="pull-left col-lg-8" >
            <img src="http://admin.wai6.fanwe.net/images/dlzim.png" class="img-responsive col-lg-12" alt="Cinque Terre">
        </div>
        <div class="pull-left col-lg-3">
            <img src="http://admin.wai6.fanwe.net/images/dltt2.png" class="img-responsive col-lg-12" style="margin-bottom: 20px;margin-top: 55px;" alt="Cinque Terre">
            <?php $form = ActiveForm::begin(); ?>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'rememberMe')->checkbox() ?>
            <?= Html::submitButton('Login') ?>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<script>
    $(function () {
        $(".control-label").hide();
        $("#loginform-username").attr('placeholder','请输入用户名');
        $("#loginform-password").attr('placeholder','请输入密码');
        $("#loginform-username").addClass('mt25');
        $("#loginform-password").addClass('mt25');
        $("button").addClass('btn-default');
    })
</script>
</body>
</html>