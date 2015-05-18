<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php include $this->template('header','core');?>
<body id="body" style="overflow-y :scroll;overflow-x:auto;">
<link href="<?php echo R;?>css/validform.css" rel="stylesheet">
<script src="<?php echo R;?>js/validform.min.js"></script>
<section class="panel">
	<div class="panel-body">
        <table class="table table-striped table-advance table-hover">
            <?php
            foreach($data as $key=>$r) {
                if(!isset($fields[$key])) continue;
?>
                <tr>
                    <td><?php echo $fields[$key]['name'];?></td>
                    <td><?php echo $r['data'];?></td>
                </tr>

            <?php
            }
            ?>
        </table>
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