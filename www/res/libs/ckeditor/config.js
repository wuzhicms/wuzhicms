/** * @license Copyright (c) 2003-2022, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
  // %REMOVE_START%
  // The configuration options below are needed when running CKEditor from source files.
  // devtools  开发者工具
  config.plugins =
    "dialogui,dialog,about,a11yhelp,dialogadvtab,basicstyles,bidi,blockquote,notification,button,toolbar,clipboard,panelbutton,panel,floatpanel,colorbutton,colordialog,xml,ajax,templates,menu,contextmenu,copyformatting,div,editorplaceholder,resize,elementspath,enterkey,entities,popup,filetools,filebrowser,find,floatingspace,listblock,richcombo,font,fakeobjects,forms,format,horizontalrule,htmlwriter,iframe,wysiwygarea,indent,indentblock,indentlist,smiley,justify,menubutton,language,link,list,liststyle,magicline,maximize,newpage,pagebreak,pastetext,pastetools,pastefromgdocs,pastefromlibreoffice,pastefromword,preview,print,removeformat,save,selectall,showblocks,showborders,sourcearea,specialchar,scayt,stylescombo,tab,table,tabletools,tableselection,undo,lineutils,widgetselection,widget,notificationaggregator,uploadwidget,uploadimage,docprops,autocorrect,codesnippet,codesnippetgeshi,uploadfile,imagebase,balloonpanel,balloontoolbar,image2,tableresize,textwatcher,autocomplete,textmatch,emoji";

  config.autosave_SaveKey = "wuzhicms";
  config.autosave_NotOlderThen = 1440;
  config.autosave_delay = 10; //自动保存延迟时间
  config.autosave_saveDetectionSelectors = "a[href^='javascript:__doPostBack'][id*='Save'],a[id*='Cancel']";
  config.filebrowserBrowseUrl = "/index.php?m=attachment&f=index&v=ckeditor&action=listfile";
  config.filebrowserImageBrowseUrl = "/index.php?m=attachment&f=index&v=ckeditor&action=listimage";
  config.filebrowserUploadUrl = "/index.php?m=attachment&f=index&v=ckeditor&action=uploadimage";
  config.filebrowserHtml5videoUploadUrl = "/index.php?m=attachment&f=index&v=ckeditor&action=uploadvideo"; //上传视频的地址
  // config.extraPlugins = 'codesnippet';
  // autogrow内容框自动高度
  // confighelper内容框文字提示
  config.extraPlugins = "html5video,confighelper,wzimages,timestamp";
  config.placeholder =
    '<p style="text-align:center;">注意事项</p>1.段落无需首行缩进，内容页将自动识别段落并进行首行缩进；</br> 2.编辑器支持拖拽上传图片，上传前请确保图片宽度不要大于900px；</br>3.编辑器支持从word直接粘贴，请确保图片宽度不要大于900px；';
  config.uiColor = "#ffffff";
  config.allowedContent = true;
  config.height = 450;
  config.skin = "office2013";
  //config.removeButtons = 'Underline,JustifyCenter';
  config.toolbar_normal = [
    { name: "document", items: ["Source", "Preview", "NewPage"] },
    { name: "clipboard", items: ["Undo", "Redo", "-", "PasteText", "Find", "Replace"] },
    // { name: 'clipboard', items: [ 'Undo', 'Redo', '-', 'PasteText', 'PasteFromWord', 'Find', 'Replace' ] },
    { name: "basicstyles", items: ["Bold", "Italic", "Underline", "Strike", "RemoveFormat"] },
    { name: "paragraph", items: ["NumberedList", "BulletedList", "Outdent", "Indent", "JustifyLeft", "JustifyCenter", "JustifyRight","JustifyBlock"] },
    { name: "links", items: ["Link", "Unlink", "Anchor"] },
    { name: "insert", items: ["Image", "Wzimages", "Html5video", "Table", "HorizontalRule", "PageBreak", "SpecialChar"] },
    { name: "styles", items: ["Format", "Font", "FontSize"] },
    { name: "colors", items: ["TextColor", "BGColor"] },
    { name: "tools", items: ["Blockquote", "ShowBlocks", "Maximize"] },
  ];
  config.toolbar_basic = [
    { name: "document", items: ["Source", "Preview"] },
    { name: "clipboard", items: ["Undo", "Redo"] },
    { name: "basicstyles", items: ["Bold", "Italic", "Underline", "Strike", "RemoveFormat"] },
    { name: "paragraph", items: ["NumberedList", "BulletedList", "Outdent", "Indent","JustifyLeft", "JustifyCenter", "JustifyRight","JustifyBlock"] },
    { name: "links", items: ["Link", "Unlink", "Anchor"] },
    { name: "insert", items: ["Image", "Wzimages", "Html5video", "Table"] },
    { name: "styles", items: ["Format", "Font", "FontSize"] },
    { name: "colors", items: ["TextColor", "BGColor"] },
    { name: "tools", items: ["Maximize"] },
  ];
  config.removeDialogTabs = "image:advanced;link:advanced";

};
