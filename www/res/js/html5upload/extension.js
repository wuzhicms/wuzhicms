//插入附件的回调函数
function callback_thumb_dialog(filename,htmlid) {
    temp = filename.split(',');
    filename = temp[0];
    var dialog = top.dialog.get(window);
	var htmlid = htmlid ? htmlid : 'testid';
    dialog.close(filename).remove();
    return false;
}

//插入附件的回调函数
function callback_ck_images(files,htmlid) {
	var dialog = top.dialog.get(window);
	var htmlid = htmlid ? htmlid : 'testid';
	//alert(filename);
	var imgcode = '';
    var temp = '';
    var file_url = '';
    if(files!='') {
		var files_arr = files.split('|');
		$.each( files_arr, function( key, value ) {
            temp = value.split(',');
            file_url = temp[0];
			imgcode += '<p class="wz-images-list"><img src="'+file_url+'" style="max-width: 900px;"></p>';
		});
	}
	dialog.close(imgcode).remove();
	//dialog.close('<img src="http://dev.wuzhicms.com/uploadfile/2017/02/22/20170222090318AE29No.png" style="max-width: 900px;">').remove();
	//console.log(filename);
	console.log(htmlid);
	return false;
}

//插入附件的回调函数
function insert_file_callback(filename) {
    var temp = n.split(',');
    var file_url = temp[0];
	document.getElementById('thumb').innerHTML += "<img src='"+file_url+"' width='60' height='60'>";
}

/**
 * 多文件上传回调方法
 *
 * @author tuzwu
 * @createtime
 * @modifytime
 * @param	
 * @return
 */
function callback_more_dialog(filename,htmlid,is_thumb,htmlname)
{
	var file_array = filename.split('|');
	var str = '';
	$.each( file_array, function(i, n) {
		var temp = n.split(',');
		var file_url = temp[0];
		var file_alt = temp[1];
		var file_id = temp[2];
		str += '<li id="file_node_'+file_id+'"><input type="hidden" name="'+htmlname+'['+file_id+'][url]" value="'+file_url+'"> <img src="'+file_url+'" alt="'+file_alt+'" onclick="img_view(this.src);"> <textarea name="'+htmlname+'['+file_id+'][alt]" onfocus="if(this.value == this.defaultValue) this.value = \'\'" onblur="if(this.value.replace(\' \',\'\') == \'\') this.value = this.defaultValue;">'+file_alt+'</textarea> <a class="btn btn-danger btn-xs" href="javascript:remove_file('+file_id+');">移除</a></li>';
	});

	var dialog = top.dialog.get(window);
	dialog.close(str).remove();
	return false;
}

/**
 *移除文件
 *
 * @author tuzwu
 * @createtime
 * @modifytime
 * @param	
 * @return
 */
function remove_file(file_id)
{
	$('#file_node_'+file_id).remove();
}

function img_view(src)
{
	var ext = src.substring(src.lastIndexOf("."));
	ext = ext.toLowerCase();
	if(!/\.(gif|jpg|jpeg|png|bmp)$/.test(ext)) 
	{
		return false;
	}
    if(src.lastIndexOf("?")==0) {
        openiframe(src,'img_view','图片预览','800','560');
    } else {
        top.dialog({
            title: '图片预览',
            quickClose: true,
            content: '<img src="'+src+'" style="max-width:700px;max-height:500px;">'
        }).show();
    }
}

/**
 * 点评
 *
 * @author tuzwu
 * @createtime
 * @modifytime
 * @param
 * @return
 */
function callback_dianping(filename,htmlid,is_thumb,htmlname)
{
	var file_array = filename.split('|');
	var str = '';
	$.each( file_array, function(i, n) {
		var temp = n.split(',');
		var file_url = temp[0];
		var file_alt = temp[1];
		var file_id = temp[2];
		str += '<li id="file_node_'+file_id+'"><input type="hidden" name="'+htmlname+'['+file_id+'][url]" value="'+file_url+'"> <img src="'+file_url+'" alt="'+file_alt+'" onclick="img_view(this.src);"></li>';
	});
	var dialog = top.dialog.get(window);
	dialog.close(str).remove();

	return false;
}

function callback_images2(filename,htmlid,is_thumb,htmlname)
{
	var file_array = filename.split('|');
	var str = '';
	$.each( file_array, function(i, n) {
		var temp = n.split(',');
		var file_url = temp[0];
		var file_alt = temp[1];
		var file_id = temp[2];
		if(temp[3]) htmlname = temp[3];
		str += '<li id="file_node_'+file_id+'"><table class="table table-striped table-advance table-hover"><tr><td><input type="hidden" name="'+htmlname+'['+file_id+'][url]" value="'+file_url+'"> <img src="'+file_url+'" alt="'+file_alt+'" onclick="img_view(this.src);"></td><td> <textarea style="height:50px;" name="'+htmlname+'['+file_id+'][alt]" onfocus="if(this.value == this.defaultValue) this.value = \'\'" onblur="if(this.value.replace(\' \',\'\') == \'\') this.value = this.defaultValue;">'+file_alt+'</textarea></td><td><a class="btn btn-danger btn-xs" href="javascript:remove_file('+file_id+');">移除</a></td></tr></table></li>';
	});

	var dialog = top.dialog.get(window);
	dialog.close(str).remove();
	return false;
}

function callback_downfile(filename)
{
    var file_array = filename.split('|');
    var str = '';
    $.each( file_array, function(i, n) {
        var temp = n.split(',');
        var file_url = temp[0];
        var file_name = temp[1];
        var file_id = temp[2];
        var htmlname = temp[3];
        str += '<li id="file_node_'+file_id+'"><input type="text" name="'+htmlname+'['+file_id+'][name]" value="'+file_name+'" class="downfile-text1" placeholder="下载服务器名称"> <input type="text" name="'+htmlname+'['+file_id+'][url]" value="'+file_url+'" class="downfile-text2" placeholder="http://下载地址"> <a class="btn btn-danger btn-xs" href="javascript:remove_file('+file_id+');">移除</a></li>';
    });

    var dialog = top.dialog.get(window);
    dialog.close(str).remove();
    return false;
}