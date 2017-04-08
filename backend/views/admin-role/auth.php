<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/31
 * Time: 21:16
 */
?>

<?php ActiveForm::begin(); ?>
<table class="table table-striped table-advance table-hover">
    <thead>
    <tr>
        <th class="tablehead" colspan="2">角色授权: <?=$model->name?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($admin_menu as $k => $v): ?>
        <tr>
            <td><label><input onclick="checkAll(this)" id="<?= $k ?>" class="<?= $k ?>" type="checkbox"> <?= $v['name'] ?></label></td>
            <td></td>
        </tr>
        <?php foreach ($v['nodes'] as $kk => $vv):?>
            <tr>
                <td style="padding-left: 50px;"><label><input type="checkbox" onclick="checkAll(this)" id="<?= $kk ?>" class="<?= ' '.$k.' ' ?>"><?= $vv['name'] ?></label></td>
                <td>
                    <?php foreach ($vv['controllers'] as $kkk => $vvv): ?>
                        <?php foreach ($vvv['actions'] as $kkkk => $vvvv):?>
                            <label><input name="node[]" class="<?= ' '.$k.' '.$kk.' ' ?>" value="<?= strtolower($kkk.'/'.$kkkk) ?>" type="checkbox" <?php if(in_array(strtolower($kkk.'/'.$kkkk),$authRules)) echo "checked"; else echo "";?>> <?= $vvvv['name'] ?></label>
                        <?php endforeach;?>
                    <?php endforeach;?>
                </td>
            </tr>
        <?php endforeach;?>
    <?php endforeach;?>
    </tbody>
</table>
<div class="form-group">
    <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
</div>
<?php ActiveForm::end(); ?>
<script>
    function checkAll(obj) {
        var id = $(obj).attr('id');
        $('.'+id).prop('checked', obj.checked);
    }
</script>
