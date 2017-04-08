<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Admin */

$this->title = '更新角色';
?>
<div class="admin-update">
    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
