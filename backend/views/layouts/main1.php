<?php
use backend\controllers\menu;
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Bootstrap 实例 ';
$admin_nav = menu::get_menu();
//$admin_menu_node = menu::get_menu_node($admin_menu);
$admin_menu = $admin_nav['admin_menu'];
$currentNav = $admin_nav['currentNav'];
$breadCrumb = $admin_nav['breadCrumb'];
$currentUrl = $admin_nav['currentUrl'];
$currentNode = $admin_nav['currentNode'];
//var_dump($currentNode);die;
?>
<?php $this->beginPage() ?>
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
        .panel-group{max-height:770px;overflow: auto;}
        .leftMenu{margin:10px;margin-top:5px;}
        .leftMenu .panel-heading{font-size:14px;padding-left:20px;height:36px;line-height:36px;color:white;position:relative;cursor:pointer;}/*转成手形图标*/
        .leftMenu .panel-heading span{position:absolute;right:10px;top:12px;}
        .leftMenu .menu-item-left{padding: 2px; background: transparent; border:1px solid transparent;border-radius: 6px;}
        .leftMenu .list-group-item:hover{background:#C4E3F3;}
        .left_menu_active{background:#C4E3F3;}
    </style>
</head>
<body>
<?php $this->beginBody() ?>
<div class="head">
    <div class="clearfix hidden">
        <div class="pull-left">
            <div class="navbar-header">
                <a class="navbar-brand">菜鸟教程</a>
            </div>
        </div>
        <div class="pull-right">
            <ul class="nav navbar-nav" style="">
                <li class="pull-left"><a> 欢迎您，<?= Yii::$app->user->identity->username; ?></a></li>
                <li class="pull-left"><a href="#"><span class="glyphicon glyphicon-user"></span>清理缓存</a></li>
                <li class="pull-left"><a href="<?= Yii::$app->urlManager->createUrl(['/index/logout']) ?>"><span class="glyphicon glyphicon-log-in"></span> <?php if(Yii::$app->user->isGuest) echo '登录';else echo '退出'?></a></li>
            </ul>
        </div>
    </div>
    <nav class="navbar navbar-default" role="navigation" style="margin-bottom: 0px;">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">菜鸟教程sdfasdfsdafsdfd</a>
            </div>
            <div>
                <ul class="nav navbar-nav navbar-left">
                    <?php foreach ($admin_menu as $k => $v){
                        echo '<li class="';
                        if($currentNav === strtolower($k)){
                            echo 'active';
                        }
                        echo '" data-module="'.strtolower($k).'">';
                        echo '<a href="'.Yii::$app->urlManager->createUrl([strtolower($v['url'])]).'">'.$v['name'].'</a></li>';
                     } ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <?= Yii::$app->user->identity->username; ?>
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu" style="min-width: 30px;">
                            <li><a href="<?= Yii::$app->urlManager->createUrl('index/logout') ?>"><?php if(Yii::$app->user->isGuest) echo '登录';else echo '退出'?></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
    <div class="pull-left col-md-2 left_menu" style="padding-right: 0px;padding-left: 0px;">
        <div class="panel-group table-responsive" role="tablist">
            <?php foreach ($admin_menu as $k => $v){?>
                <div class="module <?php if(strtolower($k) === strtolower($currentNav)) echo 'show';else echo 'hidden'; echo  ' '.strtolower($k);$i=0; ?>">
                    <?php foreach ($v['nodes'] as $kk => $vv){?>
                        <div class="panel panel-primary leftMenu">
                            <!-- 利用data-target指定要折叠的分组列表 -->
                            <div class="panel-heading" id="<?php echo strtolower($kk); ?>" data-toggle="collapse" data-target="#<?php echo strtolower($kk).$i; ?>" role="tab" >
                                <h4 class="panel-title">
                                    <?php echo $vv['name']; ?>
                                    <span class="glyphicon <?php if(strtolower($kk) === strtolower($currentNode)) echo 'glyphicon-chevron-up'; else echo 'glyphicon-chevron-down'; ?> right"></span>
                                </h4>
                            </div>
                            <!-- .panel-collapse和.collapse标明折叠元素 .in表示要显示出来 -->
                            <div id="<?php echo strtolower($kk).$i;$i++; ?>" class="panel-collapse collapse <?php if(strtolower($kk) === strtolower($currentNode)) echo 'in'; ?>" role="tabpanel" aria-labelledby="<?php echo strtolower($kk); ?>">
                                <ul class="list-group">
                                    <?php foreach ($vv['controllers'] as $kkk => $vvv){ ?>
                                        <li class="list-group-item text-center <?php  if(isset($vvv['check'])) echo 'left_menu_active'; ?>">
                                            <!-- 利用data-target指定URL -->
                                            <a class="menu-item-left" href="<?php echo Yii::$app->urlManager->createUrl(['/'.strtolower($vvv['url'])]);?>">
                                                <?php echo $vvv['name']; ?>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div><!--panel end-->
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="pull-left col-md-10" style="padding-right: 0px;padding-left: 0px;margin-top: 6px;">
        <ol class="breadcrumb">
            <li><a href="<?= Yii::$app->urlManager->createUrl(strtolower($currentUrl)) ?>"><?= $breadCrumb['0'] ?></a></li>
            <li><a href="<?= Yii::$app->urlManager->createUrl(strtolower($currentUrl)) ?>"><?= $breadCrumb['1'] ?></a></li>
            <li><a href="<?= Yii::$app->urlManager->createUrl(strtolower($currentUrl)) ?>"><?= $breadCrumb['2'] ?></a></li>
            <li class="active"><?= $breadCrumb['3']; ?></li>
        </ol>
        <div>
            <?= $content ?>
        </div>
    </div>
<?php $this->endBody() ?>
</body>
<script>
    $(function(){
        $(".panel-heading").click(function(e){
            /*切换折叠指示图标*/
            $(this).find("span").toggleClass("glyphicon-chevron-down");
            $(this).find("span").toggleClass("glyphicon-chevron-up");
        });
    });
</script>
</html>
<?php $this->endPage() ?>