<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\helpers\Url;

$this->title = '环球石材管理系统-文章列表';
?>
<div class="dux-tools">
    <div class="tools-function clearfix">
        <div class="float-left">
            <a class="button button-small bg-main icon-list" href="">文章分类</a>
        </div>
        <div class="button-group float-right">
            <a class="button button-small bg-dot icon-plus dropdown-toggle" href="<?php echo Url::toRoute(yii::$app->params['url']['articlecateadd']);?>"> 添加</a> 
        </div>
    </div>
</div>
<div class="admin-main">
    <div class="panel dux-box">
        <div class="table-responsive">
            <table id="table" class="table table-hover table-tr-hide">
                <tbody>
                    <tr class="trshow">
                        <th>ID</th>
                        <th>排序</th>
                        <th>分类名称</th>
                        <th>操作</th>
                    </tr>
                    <?php if(is_array($data)&&!empty($data)) :?>
                        <?php foreach($data as $k => $v) :?>
                            <tr <?php if($v['level'] == '0'): ?> class="trshow" <?php else: ?> style="display:none;" <?php endif; ?> >
                                <td>
                                    <?php if($v['level'] == '0') {
                                        if (isset($data[$k+1]) && $data[$k+1]['level'] == 2) {
                                            echo '<a href="#" class="a-btn icon-plus-square">&nbsp;'.Html::encode($v['id']).'</a>';
                                        }
                                        else
                                        {
                                            echo '<a href="#" class="a-btn icon-square-o">&nbsp;'.Html::encode($v['id']).'</a>';
                                        }
                                        
                                    }else{
                                        echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.Html::encode($v['id']);
                                    } ?>
                                </td>
                                <td><?= Html::encode($v['order'])?></td>
                                <td><?= $v['str_repeat'].'&nbsp;'.$v['name'];?></td>
                                <td>
                                    <!-- update -->
                                    <?php if(in_array('articlecateup', $power)): ?>
                                     <a class="button bg-blue button-small icon-pencil" href="<?php echo Url::toRoute(yii::$app->params['url']['articlecateup']);?>?id=<?= Html::encode($v['id'])?>" title="修改"></a>
                                    <?php endif; ?>
                                    <!-- delete -->
                                    <?php if(in_array('articlecatedel', $power)): ?>
                                    <a class="button bg-red button-small icon-trash-o js-del"  href="javascript:;"  url="<?php echo Url::toRoute(yii::$app->params['url']['articlecatedel']);?>?isCsrf=0" data="<?= Html::encode($v['id'])?>" title="删除"></a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach;?> 
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    Do.ready('base', function () {
        $('#table').duxTable();
    });
$(function(){
    var isShow = false;
    $('table tr.trshow a.a-btn').on('click', function(){
        var tr = $(this).parents('tr.trshow'), down = 'icon-plus-square', right = 'icon-minus-square';
        if($(this).hasClass(down)){ 
            isShow = false;
            $(this).removeClass(down).addClass(right);
        }else if($(this).hasClass(right)){
            isShow = true;
            $(this).removeClass(right).addClass(down);
        }
        getNext(tr.next());
    });
    
    function getNext(next){
        if(!next.hasClass('trshow')){
            if(isShow){
                next.hide();
            }else{
                next.show();
            }
            next = next.next();
            getNext(next);
        }
    }

})
</script>