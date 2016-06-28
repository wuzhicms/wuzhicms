<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php include $this->template('header','core');?>
<body id="body" style="overflow-y :scroll;overflow-x:auto;">
<link href="<?php echo R;?>css/validform.css" rel="stylesheet">
<script src="<?php echo R;?>js/validform.min.js"></script>
<style>
    img{
        max-width: 450px;;
    }
</style>
<section class="panel">
	<div class="panel-body">
        <table class="table table-striped table-advance table-hover">
            <?php
            foreach($data as $key=>$r) {
                if(!isset($fields[$key])) continue;
?>
                <tr>
                    <td width="180"><?php echo $fields[$key]['name'];?></td>
                    <td><?php if($fields[$key]['formtype']=='image'){echo "<img src='".$r['data']."'>";} else {echo $r['data'];}?></td>
                </tr>

            <?php
            }
            ?>

        </table>
        <?php if($company_info) {?>
            <form name="myform" action="?m=member&f=index&v=setcompany<?php echo $this->su();?>" method="post">
        <table class="table table-striped table-advance table-hover">
                <tr>
                    <td>是否为认证企业？</td>
                    <td><label><input type="radio" name="check_company" value="1" <?php if($company_info['check_company']) echo 'checked';?>> 是 </label> <label><input type="radio" name="check_company" value="0" <?php if(!$company_info['check_company']) echo 'checked';?>> 否 </label></td>
</tr>
            <tr>
                <td>营业执照是否认证？</td>
                <td><label><input type="radio" name="check_cert" value="1" <?php if($company_info['check_cert']) echo 'checked';?>> 是 </label> <label><input type="radio" name="check_cert" value="0" <?php if(!$company_info['check_cert']) echo 'checked';?>> 否 </label></td>
            </tr>
            <tr>
                <td>是否缴纳保证金？</td>
                <td><label><input type="radio" name="check_money" value="1" <?php if($company_info['check_money']) echo 'checked';?>> 是 </label> <label><input type="radio" name="check_money" value="0" <?php if(!$company_info['check_money']) echo 'checked';?>> 否 </label></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <input type="hidden" name="uid" value="<?php echo $uid;?>">
                    <input class="btn btn-info" type="submit" name="submit" value="提交" id="submit"></td>
            </tr>
        </table>
            </form>
        <?php } elseif($modelid==11) {
            ?>
            <form name="myform" action="?m=member&f=index&v=setcompany<?php echo $this->su();?>" method="post">
                <table class="table table-striped table-advance table-hover">
                    <tr>
                        <td>  </td><!--审核区域-->
                        <td><label><input type="radio" name="check_company" value="1" <?php if($member['checkmec']==1) echo 'checked';?>> 审核通过 </label> <label><input type="radio" name="check_company" value="0" <?php if(!$member['checkmec']) echo 'checked';?>> 待审核 </label> <label><input type="radio" name="check_company" value="2" <?php if($member['checkmec']==2) echo 'checked';?>> 审核不通过 </label></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="hidden" name="uid" value="<?php echo $uid;?>">
                            <input class="btn btn-info" type="submit" name="submit" value="提交" id="submit"></td>
                    </tr>
                </table>
            </form>
        <?php
        }?>
	</div>
</section>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function(){
		$(".form-horizontal").Validform({
			tiptype:3,
            callback:function(form){
                $("#submit").click();
            }

        });
        $("#body").niceScroll({styler:"fb",cursorcolor:"#CAD3D5",cursorwidth: '3', cursorborderradius: '10px', background: '#E2E7E8', cursorborder: '',horizrailenabled:false});

    });
</script>