/*
 * @Author: 一根鱼骨棒
 * @Date: 2022-05-07 09:34:31
 * @LastEditTime: 2022-05-07 09:54:38
 * @LastEditors: 一根鱼骨棒
 * @Description:
 * @FilePath: \WWW\wuzhi6source\res\js\ckeditor\plugins\wzimages\plugin.js
 * @Software: VScode
 * @Copyright 2022
 */
/**
 * @license Copyright (c) 2003-2022, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see LICENSE.md or https://ckeditor.com/legal/ckeditor-oss-license
 */
CKEDITOR.plugins.add("wzimages", {
  icons: "wzimages", // %REMOVE_LINE_CORE%
  lang: "zh-cn", // %REMOVE_LINE_CORE%
  init: function (editor) {
    editor.addCommand("wzimages", CKEDITOR.plugins.wzimages),
      editor.ui.addButton && editor.ui.addButton("Wzimages", { label: editor.lang.wzimages.toolbar, command: "wzimages", toolbar: "document,60" });
  },
});
CKEDITOR.plugins.wzimages = {
  exec: function (a) {
    openiframe(
      web_url +
        "index.php?m=attachment&f=index&v=upload_dialog&callback=callback_ck_images&htmlid=" +
        a.name +
        "&limit=10&htmlname=form[thumb]&ext=jpg|png|gif&token=" +
        ck_ext_token +
        "&_menuid=26",
      a.name,
      "loading...",
      810,
      400,
      5
    );
  },
  canUndo: !1,
  readOnly: 1,
  modes: { wysiwyg: 1 },
};
