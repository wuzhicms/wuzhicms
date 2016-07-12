<?php defined('IN_WZ') or exit('No direct script access allowed'); ?><div id="filelist">Your browser doesn't have Flash, Silverlight or HTML5 support.</div>
<div id="container">
    <a id="pickfiles" href="javascript:;">[Select files]</a> 
    <a id="uploadfiles" href="javascript:;">[Upload files]</a>
</div>

<br />
<pre id="console"></pre>
<pre id="thumb"></pre>


<script type="text/javascript">
// Custom example logic

var uploader = new plupload.Uploader({
	runtimes : 'html5,flash,silverlight,html4',
	browse_button : 'pickfiles', // you can pass in id...
	container: document.getElementById('container'), // ... or DOM Element itself
	url : '<?php echo WEBURL;?>index.php?m=attachment&f=index&v=h5upload',
	flash_swf_url : '<?php echo R;?>js/html5upload/Moxie.swf',
	silverlight_xap_url : '<?php echo R;?>js/html5upload/Moxie.xap',
	
	filters : {
		max_file_size : '10mb',
		mime_types: [
			{title : "Image files", extensions : "jpg,gif,png"},
			{title : "Zip files", extensions : "zip"}
		]
	},

	init: {
		PostInit: function() {
			document.getElementById('filelist').innerHTML = '';

			document.getElementById('uploadfiles').onclick = function() {
				uploader.start();
				return false;
			};
		},

		FilesAdded: function(up, files) {
			plupload.each(files, function(file) {
				document.getElementById('filelist').innerHTML += '<div id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ') <b></b></div>';
			});
			//选择文件后，就开始上传
			uploader.start();
		},

		UploadProgress: function(up, file) {
			document.getElementById(file.id).getElementsByTagName('b')[0].innerHTML = '<span>' + file.percent + "%</span>";
		},
		FileUploaded: function(up, file, info) {
			myres = JSON.parse(info.response);
			if(myres['error']) {
				alert(myres['error']['message']);
				return ;
			}
			if(myres['result']) {
				<?php echo $insert_file_callback;?>(myres['result']);
			}
			//console.info(info);
			//console.info(file);
		},
		Error: function(up, err) {
			document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
		}
	}
});

uploader.init();
</script>