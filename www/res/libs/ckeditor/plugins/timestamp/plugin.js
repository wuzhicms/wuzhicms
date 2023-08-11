/*
 * @Author: 一根鱼骨棒
 * @Date: 2022-05-07 09:33:43
 * @LastEditTime: 2022-05-07 10:46:31
 * @LastEditors: 一根鱼骨棒
 * @Description: 
 * @FilePath: \WWW\wuzhi6source\res\js\ckeditor\plugins\timestamp\plugin.js
 * @Software: VScode
 * @Copyright 2022 
 */
/**
 * Copyright (c) 2014-2022, CKSource Holding sp. z o.o. All rights reserved.
 * Licensed under the terms of the MIT License (see LICENSE.md).
 *
 * Basic sample plugin inserting current date and time into the CKEditor editing area.
 *
 * Created out of the CKEditor Plugin SDK:
 * https://ckeditor.com/docs/ckeditor4/latest/guide/plugin_sdk_intro.html
 */

// Register the plugin within the editor.
CKEDITOR.plugins.add( 'timestamp', {

	// Register the icons. They must match command names.
	icons: 'timestamp',

	// The plugin initialization logic goes inside this method.
	init: function( editor ) {

		// Define the editor command that inserts a timestamp.
		editor.addCommand( 'insertTimestamp', {

			// Define the function that will be fired when the command is executed.
			exec: function( editor ) {
				var now = new Date();

				// Insert the timestamp into the document.
				editor.insertHtml( '当前时间: <em>' + now.toString() + '</em>' );
			}
		});

		// Create the toolbar button that executes the above command.
		editor.ui.addButton( 'Timestamp', {
			label: 'Insert Timestamp',
			command: 'insertTimestamp',
			toolbar: 'insert'
		});
	}
});
