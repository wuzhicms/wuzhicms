<?php defined('IN_WZ') or exit('No direct script access allowed');?>
    <ul class="sidebar-menu" id="panel-<?php echo $menuid;?>">
        <div class="appicon center"><img src="<?php echo R;?>images/appicons/<?php echo $menuid;?>.png" alt=""></div>
        <?php
        $n = 1;
        foreach($result as $_mid=>$_panel) {
            $active = $n==1 ? 'active' : '';
            $_d = $_panel['data'] ? '&'.$_panel['data'] : '';
            $url = '?m='.$_panel['m'].'&f='.$_panel['f'].'&v='.$_panel['v'].$_d;
            echo '<li><a href="javascript:w(\''.$url.'\');" onclick="_PANEL(this,'.$_mid.',\''.$url.'\')" class="_p_menu '.$active.'" ><span>'.$MENU[$_mid].'</span></a></li>';
            $n++;
        }
        ?>
        <li></li>
    </ul>
<script type="text/javascript">
    var mypos = $("._p_menu").first();
    $("#position").html(parent.parentpos+mypos.text()+"<span>></span>");
</script>