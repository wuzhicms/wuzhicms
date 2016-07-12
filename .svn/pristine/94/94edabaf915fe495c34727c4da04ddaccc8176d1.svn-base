<?php
class test{
	function __construct() {
	}

    /**
     * 私密文件生成及下载
     */
	function index() {
		load_function('content','content');
        echo private_file('http://dev.wuzhicms.com/uploadfile/2014/12/09/1418090546149321.pdf',1);
	}

    /**
     * 筛选功能测试
     */
    function shaixuan() {
        load_function('content','content');
        //type = 套餐类别,area = 区域，city＝城市,st=排序类型,asc=降序，升序  0升序，1降序
        //$linkurl = "index.php?m=demo&f=test&v=shaixuan&page=1&pinpai=1&renqun=1&type=2&price=100_200&area=2&tese=1_2_3&st=0&asc=1";
        $urlrule = 'index.php?m=demo&f=test&v=shaixuan&pinpai={$pinpai}&renqun={$renqun}&type={$type}&price={$price}&area={$area}&tese={$tese}&st={$st}&asc={$asc}&page={$page}';
        $_POST['page_urlrule'] = 'tuan-{$pinpai}-{$renqun}-{$type}-{$price}-{$area}-{$tese}-{$st}-{$asc}-{$page}.html';
        $page_fields = array();
        $page_fields['pinpai'] = 2;
        $page_fields['renqun'] = 3;
        $page_fields['type'] = 4;
        $page_fields['price'] = '100_200';
        $page_fields['area'] = 5;
        $page_fields['tese'] = '1_2_3';
        $page_fields['st'] = '6';
        $page_fields['asc'] = 0;

        echo _pageurl($_POST['page_urlrule'],2,$page_fields);
        echo "<br>";
        $_POST['page_fields'] = $page_fields;
        echo filter('pinpai','88');
        echo "<br>";
        echo filter('renqun','55');
    }
    function pay_callback() {
        $api = load_class('pay_callback','order');
        if($api->update('20150120237490658')) {
            echo 'ok';
        }
    }
}
