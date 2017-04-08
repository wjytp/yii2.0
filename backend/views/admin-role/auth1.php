<?php
use yii\widgets\ActiveForm;
?>
<?php ActiveForm::begin(); ?>
    <table class="table table-bordered table-hover definewidth m10">
        <tr>
            <td width="10%" class="tableleft">标题</td>
            <td><input type="text" name="name" value="<?= $model->name ?>"/></td>
        </tr>
        <tr>
            <td class="tableleft">状态</td>
            <td>
                <input type="radio" name="status" value="1" checked /> 启用
                <input type="radio" name="status" value="0"  /> 禁用
            </td>
        </tr>
        <tr>
            <td class="tableleft">权限</td>
            <td>
                <ul>
                    <?php foreach($admin_menu as $k => $v): ?>
                        <li>
                            <label class='checkbox inline'><input type='checkbox' name='group[]' value='' /><?= $v['name'] ?></label>
                            <?php foreach ($v['nodes'] as $kk => $vv):?>
                                <div class="checkbox">
                                    <span><?= $vv['name'] ?>:</span>
                                    <?php foreach ($vv['controllers'] as $kkk => $vvv): ?>
                                        <?php foreach ($vvv['actions'] as $kkkk => $vvvv):?>
                                            <label><input type="checkbox" value="<?= strtolower($kkk.'/'.$kkkk) ?>" name='node[]'><?= $vvvv['name'] ?></label>
                                        <?php endforeach; ?>
                                    <?php endforeach;?>
                                </div>
                            <?php endforeach;?>
                        </li>
                    <?php endforeach;?>
                </ul>
            </td>
        </tr>
        <tr>
            <td class="tableleft"></td>
            <input name="ok" type="hidden" value="ok">
            <td>
                <button type="submit" class="btn btn-primary" type="button">保存</button> &nbsp;&nbsp;<button type="button" class="btn btn-success" name="backid" id="backid">返回列表</button>
            </td>
        </tr>
    </table>
    <?php ActiveForm::end(); ?>
<script>
    $(function () {
        $(':checkbox[name="group[]"]').click(function () {
            $(':checkbox', $(this).closest('li')).prop('checked', this.checked);
        });

        $('#backid').click(function(){
            window.location.href="index.html";
        });

    });
</script>
