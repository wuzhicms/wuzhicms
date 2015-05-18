<?php
class upload {
	function __construct() {
		//parent::__construct();
	}
	function index(){
		$form = load_class('form');
		echo '<!DOCTYPE html><html xmlns="http://www.w3.org/1999/xhtml" dir="ltr"><head><meta http-equiv="content-type" content="text/html; charset=utf-8"/><title>Plupload - Events example</title>';

		echo $form->upload('insert_file_callback');
		//include T('attachment','upload','default');
	}
	function openiframe() {
		//include T('demo')
		include T('demo','openiframe','default');
	}
}
