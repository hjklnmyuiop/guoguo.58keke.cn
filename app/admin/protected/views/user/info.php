<?php
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = '海花岛游戏-用户详情';
?>
<div class="admin-main">
    <div class="panel dux-box  active">
        <div class="panel-head">
            <strong>用户详情</strong>
        </div>
        <div class="table-responsive">
            <table class="table">
                <tbody>

                    <tr>
                        <td align="right">昵称：</td>
                        <td><?php echo isset($user['name']) ? $user['name'] : '';?>   </td>
						<td align="right">性别：</td>
                        <td><?php echo ($user['sex']==1) ? '男' : '女';?></td>
                    </tr>

                   <tr>
					<td align="right">地址：</td>
                        <td><?php echo isset($user['address']) ? $user['address'] : '';?>   </td>
                        <td align="right">电话号码：</td>
                        <td><?php echo isset($user['phone']) ? $user['phone'] : '';?></td>
					</tr>
					 <tr>
                         <td align="right">邮箱：</td>
                         <td><?php echo isset($user['email']) ? $user['email'] : '';?>   </td>
                        <td align="right">最后登录时间：</td>
                        <td><?php echo isset($user['lastlogin']) ? date("Y-m-d H:i:s",$user['lastlogin']) : '';?></td>
					</tr>
                </tbody>
            </table>
        </div>
    </div>
</div>