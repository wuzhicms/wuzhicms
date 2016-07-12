<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
include $this->template('header','core');
?>
<body class="body pxgridsbody">
<script type="text/javascript" src="<?php echo R;?>js/swfobject.js"></script>
<section class="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <?php echo $this->menu($GLOBALS['_menuid']);?>

                <div class="panel-body">
                    <a href="?m=template&f=index&v=listing&dir=<?php echo $dir.$this->su();?>"><img src="<?php echo R?>images/icon/folder-upload.png" />&nbsp;返回上级目录</a>
<span class="pull-right">
文件路径：<?php echo $dir.'/'.$file.'.html';?></span>
                <div style="width:1000px; margin:0px auto; display:block; overflow:hidden">
                    <div id="flash-loader">
                    </div>

                </div>

<textarea id="wzhtml" style="display:none">
<?php echo $code;?>
</textarea>

                <div id="flashContent" style="width:100%">
                </div>
                    <div class="col-sm-4 input-group">
                        更新时间：<?php echo time_format($r['addtime']);?>
                    </div>

                <script type="text/javascript">
                    function onEditorLoaded(){
                        document.getElementById('ctlFlash').setText( document.getElementById('wzhtml').value );
                    }

                    var flashvars = {
                        parser: "html",
                        readOnly: true,
                        preferredFonts : "|Consolas|Courier New|Courier|Arial|Tahoma|",
                        fontSize : 12,
                        onload : "onEditorLoaded"
                    };
                    var params = { menu: "false", /* wmode : "transparent", */allowscriptaccess : "always" };
                    var attributes = { id: "ctlFlash", name: "ctlFlash" };
                    swfobject.embedSWF("<?php echo R;?>js/htmlEditor.swf?_=" + (new Date()).getTime(), "flash-loader", "100%", "400", "10.0.0", null, flashvars, params, attributes);


                    if( window.location.protocol != 'http:' ) {
                        alert( 'Please open the demo page via http protocol!' );
                    }

                    function loadContent( lang, textarea){
                        document.getElementById('ctlFlash').setParser(lang);
                        document.getElementById('ctlFlash').setText( document.getElementById(textarea).value );
                    }
                </script>

                </div>
            </section>
        </div>
    </div>
    <!-- page end-->
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>