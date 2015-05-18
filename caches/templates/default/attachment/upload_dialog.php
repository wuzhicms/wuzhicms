<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8 echo CHARSET;?>"/>

    <title>Plupload - jQuery UI Widget</title>

    <link rel="stylesheet" href="<?php echo R;?>js/jquery-ui/jquery-ui.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo R;?>js/html5upload/jquery.ui.plupload/css/jquery.ui.plupload.css" type="text/css" />

    <script src="<?php echo R;?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo R;?>js/jquery-ui/jquery-ui.min.js"></script>

    <!-- production -->
    <script type="text/javascript" src="<?php echo R;?>js/html5upload/plupload.full.min.js"></script>
    <script type="text/javascript" src="<?php echo R;?>js/html5upload/jquery.ui.plupload/jquery.ui.plupload.js"></script>
    <script type="text/javascript" src="<?php echo R;?>js/html5upload/i18n/zh_cn.js"></script>
    <script type="text/javascript" src="<?php echo R;?>js/html5upload/extension.js"></script>

    <!-- debug
    <script type="text/javascript" src="../../js/moxie.js"></script>
    <script type="text/javascript" src="../../js/plupload.dev.js"></script>
    <script type="text/javascript" src="../../js/jquery.ui.plupload/jquery.ui.plupload.js"></script>
    -->

</head>
<body>

<form id="form" method="post" action="../dump.php">
    <div id="uploader">
        <p>Your browser doesn't have Flash, Silverlight or HTML5 support.</p>
    </div>

</form>

<script type="text/javascript">
    // Initialize the widget when the DOM is ready
    var uplodfiles = '';
    $(function() {
        $("#uploader").plupload({
            // General settings
            runtimes : 'html5,flash,silverlight,html4',
            url : '<?php echo WEBURL;?>index.php?m=attachment&f=index&v=h5upload&cut=<?php echo $GLOBALS['cut'];?>&width=<?php echo $GLOBALS['width'];?>&height=<?php echo $GLOBALS['height'];?>',

            // User can upload no more then 20 files in one go (sets multiple_queues to false)
            max_file_count: <?php echo $limit;?>,
            <?php if($GLOBALS['cut']) { ?>
                // Resize images on clientside if we can
                resize : {
                    <?php if(isset($GLOBALS['width']) && $GLOBALS['width'] > 0) { ?>width : <?php echo $GLOBALS['width'];?>,<?php } ?>
                        <?php if(isset($GLOBALS['height']) && $GLOBALS['height'] > 0) { ?>height : <?php echo $GLOBALS['height'];?>,<?php } ?>
                            quality : 100,
                                    crop: false // crop to exact dimensions
                        },
                 <?php } ?>
            chunk_size: '10mb',
                        filters : {
                            // Maximum file size
                            max_file_size : '1000mb',
                                // Specify what files to browse for
                                    mime_types: [
                                {title : "Image files", extensions : "jpg,gif,png"},
                                {title : "Zip files", extensions : "zip"},
                                {title : "Word files", extensions : "docx"},
                                {title : "pdf", extensions : "pdf"},
                            ]
                        },
                        init: {
                            FileUploaded: function(up, file, info) {

                                myres = JSON.parse(info.response);
                                if(myres['error']) {
                                    alert(myres['error']['message']);
                                    return ;
                                }
                                if(myres['result']) {
                                    if(<?php echo $limit;?> > 1) uplodfiles += myres['result']+','+myres['filename']+','+myres['id']+'|';
                                    else uplodfiles += myres['result']+'|';
                                }

                            },
                            UploadComplete: function() {
                                if(uplodfiles!='') {
                                    uplodfiles = uplodfiles.substring(0, uplodfiles.lastIndexOf('|'));
                                }
                                <?php echo $callback;?>(uplodfiles,'<?php echo $htmlid;?>',<?php echo $GLOBALS['is_thumb'];?>,'<?php echo $GLOBALS['htmlname'];?>');
                                console.info(uplodfiles);
                                //console.info(file);
                            },
                        },
                        // Rename files by clicking on their titles
                        rename: true,

                            // Sort files
                                sortable: true,

                        // Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
                            dragdrop: true,

                        // Views to activate
                            views: {
                        list: true,
                                thumbs: true, // Show thumbs
                                active: 'thumbs'
                    },

                        // Flash settings
                        flash_swf_url : '<?php echo R;?>js/html5upload/Moxie.swf',

                            // Silverlight settings
                                silverlight_xap_url : '<?php echo R;?>js/html5upload/Moxie.xap'
                    });
                });

                var dialog = '';
                $(function () {
                    try {
                        dialog = top.dialog.get(window);
                    } catch (e) {
                        $('body').append(
                                '<p><strong>Error:</strong> 跨域无法无法操作 iframe 对象</p>'
                                +'<p>chrome 浏览器本地会认为跨域，请使用 http 方式访问当前页面</p>'
                        );
                        return;
                    }

                    dialog.title('上传附件');
                    //dialog.width(550);
                    //dialog.height($(document).height());
                    dialog.reset();
                })

</script>
</body>
</html>
