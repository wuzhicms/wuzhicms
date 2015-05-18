<?php
load_class('admin');

class pagedemo extends WUZHI_admin {
    function __construct() {
    }
    function index() {
echo encode('test','tessss');
exit;
        //$urlrule = '{$type}.{$ext}/|{$type}-{$page}.{$ext}';
        $urlrule = '';
        $variables = array('type'=>'show','ext'=>'shtml');
        $limit = '7';
        include $this->template('header','core');
        echo '<section class="panel">';
        echo '<header class="panel-heading"><span>分页</span></header>';
        echo ' <div class="panel-body">';
        echo '<div>';
        echo ' <ul class="pagination pagination-lg">';
        echo $pages = pages(28, $GLOBALS['page'], 20, $urlrule, $variables,$limit);
        echo '</ul>';
        echo '</div>';
        echo '</div>';
        echo '</section>';



    }
}
