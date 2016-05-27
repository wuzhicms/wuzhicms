/**
 * Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	// %REMOVE_START%
	//config.startupFocus = true;
	//config.autosave_SaveKey = 'wuzhicms';
	//config.autosave_NotOlderThen = 1440;
	//config.autosave_delay = 60;//自动保存延迟时间
	//config.autosave_saveDetectionSelectors = "a[href^='javascript:__doPostBack'][id*='Save'],a[id*='Cancel']";
	config.filebrowserBrowseUrl = '/index.php?m=attachment&f=index&v=ckeditor&action=listimage';
	config.filebrowserUploadUrl = '/index.php?m=attachment&f=index&v=ckeditor&action=uploadimage';
	config.uiColor = '#ffffff';
	config.allowedContent = true;
	config.height = 300;
	config.toolbar_normal = [
		{ name: 'document', items: [ 'Source', 'Preview' ] },
		{ name: 'clipboard', items: [ 'Undo', 'Redo', '-', 'PasteText', 'PasteFromWord', 'Find', 'Replace' ] },
		{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat' ] },
		{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList',  'Outdent', 'Indent',  'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'BidiLtr', 'BidiRtl' ] },
		{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
		{ name: 'insert', items: [ 'Image', 'Flash', 'Table',  'HorizontalRule', 'PageBreak', 'Iframe' ] },
		{ name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
		{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
		{ name: 'tools', items: ['CodeSnippet','Blockquote','ShowBlocks','Maximize' ] }
	];
	config.toolbar_basic = [
		{ name: 'document', items: [ 'Source', 'Preview' ] },
		{ name: 'clipboard', items: [ 'Undo', 'Redo'] },
		{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat' ] },
		{ name: 'paragraph', items: [ 'NumberedList', 'BulletedList',  'Outdent', 'Indent',  'JustifyLeft', 'JustifyCenter', 'JustifyRight'] },
		{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
		{ name: 'insert', items: ['Image', 'Table'] },
		{ name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
		{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
		{ name: 'tools', items: ['Maximize' ] }
	];
};

