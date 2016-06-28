<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","head",TPLID); ?>
<div class="headimg"><img src="<?php echo R;?><?php echo TPLID;?>/images/headimg.jpg" alt=""><div class="headimgtitle"><div class="title"><span>您的支持是我们最大的动力！</span></div></div></div>
<div class="white-section">
    <div class="container">
        <div class="crumbs"><a href="<?php echo WEBURL;?>">首页</a><span> &gt; 留言板</span></div>
        <div class="row">
            <div class="span12">
                <form name="myform" action="" method="post" id="myform">
                    <table width="100%" cellspacing="0" class="table_form">
                        <tr>
                            <th width="150" align="right">您登录的用户名：</th>
                            <td><?php echo $_username;?></td>
                        </tr>
                        <?php $n=1;if(is_array($field_list)) foreach($field_list AS $info) { ?>
                        <tr>
                            <th align="right"><?php if($info['star']) { ?><font color="red">*</font><?php } ?> <?php echo $info['name'];?>：</th>
                            <td><?php echo $info['form'];?>
                                <span class="tablewarnings"><?php echo $info['remark'];?></span></td>
                        </tr>
                        <?php $n++;}?>
                        <tr>
                            <th align="right">验证码：</th>
                            <td>
                                <input type="text" id="Verificationcode" name="checkcode" class="form-control" placeholder="验证码" onfocus="javascript:document.getElementById('code_img').src='<?php echo WEBURL;?>api/identifying_code.php?w=110&h=40&rd='+Math.random();void(0);"> <img src="<?php echo R;?>images/logincode.gif" id="code_img" alt="点击刷新" onclick="javascript:this.src='<?php echo WEBURL;?>api/identifying_code.php?&rd='+Math.random();void(0);">

                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td colspan="2"><label>
                                <input type="submit" name="submit" id="dosubmit" value="确 定" class="btn btn-submit"/>
                            </label></td>
                        </tr>
                    </table>
                </form>
            </div><!-- row end -->
        </div><!-- span12 end -->
    </div><!-- row end -->
</div><!-- conteiner end -->
</div>
<?php if(!isset($siteconfigs)) $siteconfigs=get_cache('siteconfigs'); include T("content","foot",TPLID); ?>