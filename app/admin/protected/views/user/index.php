<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->title = '海花岛游戏-用户列表';
?>
<div class="dux-tools">
    <div class="tools-function clearfix">
        <div class="float-left">
            <a class="button button-small bg-main icon-list" href="">用户列表</a>&nbsp;当前查询总数<?php echo $count;?>条
        </div>
		<?php if(in_array('addUser', $power)): ?>
        <div class="button-group float-right">
            <a class="button button-small bg-dot icon-plus dropdown-toggle" href="<?php echo Url::toRoute(yii::$app->params['url']['addUser']);?>"> 添加</a>
        </div>
		<?php endif; ?>
    </div>
</div>
<div class="admin-main">
    <div class="panel dux-box">
    <div class="table-tools clearfix">
        <div class="float-left">
            <?php echo html::beginForm(Url::toRoute(yii::$app->params['url']['user']), 'GET');?>
                <div class="form-inline">
                     <div class="form-group">搜索： </div>
                     <div class="form-group">
                        <div class="field">
                            <select class="input" name="search[type]" id="class_id">
                              <option value=>请选择</option>
                              <?php if(!empty($search) && is_array($search)) :?>
                              <?php foreach($search as $k=>$v):?>
                              <option value="<?= Html::encode($k)?>" <?php if (isset($searchvalue['type']) && $searchvalue['type'] == $k)  echo "selected"?> ><?= Html::encode($v)?></option>
                              <?php endforeach;?>
                              <?php endif;?>
                         </select>
                        </div>
                    </div>
                    <div class="form-group" style="margin-left: 10px;">
                        <div class="field">
                            <input type="text" class="input" id="keyword" name="search[keyword]" size="30" value="<?php echo isset($searchvalue['keyword'])?$searchvalue['keyword']: '';?>" placeholder="关键词">
                        </div>
                    </div>
                    <div class="form-group" style="margin-left: 10px;">注册时间：</div>
                     <div class="form-group">
                        <div class="field">
                            <?php echo html::textInput('search[stime]',isset($searchvalue['stime'])?$searchvalue['stime']: null, ['class' => 'input', 'size' => 25, 'id' => 'stime', 'placeholder' => '开始时间']); ?>
                            <?php echo html::textInput('search[etime]',isset($searchvalue['etime'])?$searchvalue['etime']: null, ['class' => 'input', 'size' => 25, 'id' => 'etime', 'placeholder' => '结束时间']); ?>
                        </div>
                    </div>
                    <div class="form-button">
                        <button class="button" type="submit">查询</button>
                    </div>
                </div>
            <?php echo html::endForm();?>
        </div>
    </div>
        <div class="table-responsive">
        <?php echo html::beginForm('', 'GET', ['id' => 'tableForm']);?>
            <table id="table" class="table table-hover">
                <tbody>
                    <tr class="trshow">
                        <th>用户ID</th>
                        <th>用户名称</th>

						<th>领奖点</th>
                        <th>状态</th>
                        <th>注册时间</th>
                        <th>操作</th>
                    </tr>
                    <?php if(is_array($data) && !empty($data)) :?>
                        <?php foreach($data as $k => $v) :?>
                            <tr>
                                <td><?= Html::encode($v['id'])?></td>
                                <td><?= Html::encode($v['name'])?></td>

								<td><?= Html::encode($v['address'])?></td>
                                <td><?= isset(\yii::$app->params['userStatus'][$v['status']]) ? \yii::$app->params['userStatus'][$v['status']] : '';?></td>

                                <td><?= $v['register_time'] >0 ? date('Y-m-d H:i:s', $v['register_time']) : '';?></td>
                                <td>
                                    <!-- info -->
                                    <?php if(in_array('userInfo', $power)): ?>
                                    <span class="button-group button-group-little check">
                                        <a class="button bg-sub cate-layer"  href="javascript:;" data-url="<?= Url::toRoute(yii::$app->params['url']['userInfo']) ?>?uid=<?= Html::encode($v['id'])?>" data-width="1000" data-height="600">详情</a>
                                    </span>
                                    <?php endif; ?>
                                    <!-- update -->
                                    <?php if(in_array('upUser', $power)): ?>
                                     <a class="button bg-blue button-little icon-pencil" href="<?php echo Url::toRoute(yii::$app->params['url']['upUser']);?>?uid=<?= Html::encode($v['id'])?>" title="修改"></a>
									 <?php endif; ?>
                                    <!-- delete -->
                                    <?php if(in_array('delUser', $power)): ?>
                                    <a class="button bg-red button-little icon-trash-o js-del"  href="javascript:;"  url="<?php echo Url::toRoute(yii::$app->params['url']['delUser']);?>?isCsrf=0" data="<?= Html::encode($v['id'])?>" title="删除"></a>
                                    <?php endif; ?>
                                    <span class="button-group button-group-little check">
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    <?php endif;?>
                </tbody>
            </table>
            <?php echo html::endForm(); ?>
        </div>
        <div class="panel-foot table-foot clearfix">
            <!-- 分页 start-->
                <?= $this->render('../_page', ['count' => $count, 'page' => $page]) ?>
            <!-- 分页 end-->
        </div>
    </div>
</div>
<script>
    Do.ready('base', function () {
        $('#table').duxTable();
        $('#stime').duxTime();
        $('#etime').duxTime();
    });
</script>