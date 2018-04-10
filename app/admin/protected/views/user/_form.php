<?php
use yii\helpers\Html;
?>
<script type="text/javascript" src="/style/js/Area.js"></script>
<script type="text/javascript" src="/style/js/AreaData_min.js"></script>
        <div class="collapse">
              <div class="panel active">
                <div class="panel-head"><h4>基本信息</h4></div>
                <div class="panel-body">
                

                <div class="form-group">
                    <div class="label"><label>用户名</label></div>
                    <div class="field">
                        <?php echo Html::activeTextInput($model, 'name', ['class' => 'input', 'datatype' => '*', 'size' => 30]);?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label"><label>密码</label></div>
                    <div class="field">
                    <?php if(isset($model['id']) && $model['id'] > 0): ?>
                        <?php echo Html::activePasswordInput($model, 'pawd', ['class' => 'input', 'size' => 30, 'value' => '']);?>
                    <?php else: ?>
                        <?php echo Html::activePasswordInput($model, 'pawd', ['class' => 'input', 'datatype'=> '*6-12', 'size' => 30, 'value' => '']);?>
                    <?php endif; ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label"><label>确认密码</label></div>
                    <div class="field">
                    <?php if(isset($model['id']) && $model['id'] > 0): ?>
                        <?php echo Html::passwordInput('qpawd', '', ['class' => 'input', 'recheck' => 'User[pawd]', 'size' => 30, 'value' => '']);?>
                    <?php else: ?>
                        <?php echo Html::passwordInput('qpawd', '', ['class' => 'input', 'datatype'=> '*6-12', 'recheck' => 'User[pawd]', 'size' => 30, 'value' => '']);?>
                    <?php endif; ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="label"><label>状态</label></div>
                    <div class="field">
                        <?php echo Html::activeDropDownList($model, 'status', yii::$app->params['userStatus'], ['class' => 'input','datatype' => '*']);?>
                        <div class="input-note"></div>
                    </div>
                </div>
                </div>
              </div>
        </div>
<script>
    Do.ready('base', function () {
        $('#form').duxFormPage();


    });
</script>