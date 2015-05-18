<?php
function build_calendar($month,$year,$dateArray) {
    // 日历表头，星期天开始一直到星期六
    $daysOfWeek = array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
    // 本月第一天的位置
    $firstDayOfMonth = mktime(0,0,0,$month,1,$year);

    //下一月
    $nextmonth = mktime(0,0,0,$month+1,1,$year);
    $nextmonth = date('Y-m-d',$nextmonth);

    //上一月
    //echo $year.$month;
    $month2 = str_pad($month, 2, "0", STR_PAD_LEFT);
    if($year.$month==date('Ym')) {
        $upmonthstr = '';
    } else {
        $upmonth = mktime(0,0,0,$month-1,1,$year);
        $upmonth = date('Y-m-d',$upmonth);
        $upmonthstr = "<a href='javascript:setmonth(\"$upmonth\");'><i class='glyphicon glyphicon-chevron-left'></i>上一月</a>";
    }

    // 获取本月天数
    $numberDays = date('t',$firstDayOfMonth);

    // 获取本月第一天
    $dateComponents = getdate($firstDayOfMonth);

    // 获取月份的英文单词
    $monthName = $dateComponents['month'];

    $dayOfWeek = $dateComponents['wday'];

    // 月历表头
    $today = $year.'年'.$month.'月';
    $calendar = "<table class='calendar'>";
    $calendar .= "<tr><td class='month'>$upmonthstr</td><td colspan='5' class='years'>$today</td><td class='month'><a href='javascript:setmonth(\"$nextmonth\");'>下一月<i class='glyphicon glyphicon-chevron-right'></i></a></td></tr></tr>";
    $calendar .= "<tr>";

    // 星期表头

    foreach($daysOfWeek as $day) {
        $calendar .= "<th class='header'>$day</th>";
    }

    // 开始输出日历

    // 初始化天数计数器，从1号开始

    $currentDay = 1;

    $calendar .= "</tr><tr>";

    // 使用变量 $dayOfWeek 可以保证一周七天精确输出

    if ($dayOfWeek > 0) {
        for($li=0;$li<$dayOfWeek;$li++) {
            $calendar .= "<td class='day'>&nbsp;</td>";
        }
    }
    //1个月内可预定
    $one_month = mktime(0,0,0,date('m')+1,date('d'),date('Y'));
    $one_month = date('Ymd',$one_month);

    $month = str_pad($month, 2, "0", STR_PAD_LEFT);
    $tds = intval(date('Ymd'));
    while ($currentDay <= $numberDays) {

        // 7天一行，7天一到新增一行

        if ($dayOfWeek == 7) {

            $dayOfWeek = 0;
            $calendar .= "</tr><tr>";

        }

        $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
        $cds = intval($year.$month.$currentDayRel);
        $date = "$year-$month-$currentDayRel";

        if($cds == $tds) {
            $current = '#f4f4f4';
            $ccode = '<small>X</small>';
        } elseif($cds < $tds || $cds>$one_month) {
            //echo $cds."|".$one_month;
            $current = '';
            $ccode = '<small>X</small>';
        } else {
            $current = '';
            $ccode = '<a href="javascript:;" onclick="setdate('.$year.','.$month.','.$currentDay.',this);">可预约</a>';

        }
        $calendar .= "<td class='day' rel='$date' bgcolor='$current'><span>$currentDay</span> <br> $ccode</td>";

        // 计数器

        $currentDay++;
        $dayOfWeek++;

    }

    // 最后一行表格的处理，往往最后一行不可能全部填满，需要要空格填充。

    if ($dayOfWeek != 7) {

        $remainingDays = 7 - $dayOfWeek;
        for($li=0;$li<$remainingDays;$li++) {
            $calendar .= "<td class='day'>&nbsp;</td>";
        }
    }

    $calendar .= "</tr>";

    $calendar .= "</table>";

    return $calendar;
}
function count_field($result,$order_no) {
    $number = 0;
    foreach($result as $r) {
        if($r['order_no']==$order_no) $number +=1;
    }
    return $number;
}