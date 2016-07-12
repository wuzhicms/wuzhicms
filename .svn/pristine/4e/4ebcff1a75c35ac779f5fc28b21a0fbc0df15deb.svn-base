;(function($){

    var $timePanel = null
        ,$hourTDs = null
        ,$minuteTDs = null
        ,currentTarget = null
        ,date = new Date()
        ,hourTdIdPrefix = 'timepickH_'
        ,minuteTdIdPrefix = 'timepickM_';

    var timeTablelHtml = [
        '<table>'
        ,'<tr>'
        ,'<td>时</td>'
        ,'<td><table>'
        ,'<tr><td>0</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>'
        ,'<tr><td>6</td><td>7</td><td>8</td><td>9</td><td>10</td><td>11</td></tr>'
        ,'<tr><td>12</td><td>13</td><td>14</td><td>15</td><td>16</td><td>17</td></tr>'
        ,'<tr><td>18</td><td>19</td><td>20</td><td>21</td><td>22</td><td>23</td></tr>'
        ,'</table></td>'
        ,'</tr>'
        ,'<tr><td colspan="2"><hr></td></tr>'
        ,'<tr>'
        ,'<td>分</td>'
        ,'<td><table>'
        ,'<tr><td>0</td><td>5</td><td>10</td><td>15</td><td>20</td><td>25</td></tr>'
        ,'<tr><td>30</td><td>35</td><td>40</td><td>45</td><td>50</td><td>55</td></tr>'
        ,'</table></td>'
        ,'</tr>'
        ,'<tr><td> </td><td align="right"><a href="javascript:void(0)">确定</a></td></tr>'
        ,'</table>'
    ].join('');

    // 默认设置
    var defOptions = {
        // 偏移量
        offsetX:0
        ,offsetY:30
        // 格式化输出
        ,format:'hh:mm'
        // 样式
        ,css:{'cursor':'pointer'}
        // 点确定触发的事件
        ,onOK:function(val,target){
            target.val(val);
        }
    }


    $.fn.timepick = function(options,param){
        options = options || {};
        return this.each(function(){
            var state = $.data(this, 'timepick');
            // 如果已经存在,只设置options
            if (state){
                $.extend(state.options, options);
            } else { // 如果不存在根据当前dom节点绑定timepick参数
                state = $.data(this, 'timepick', {
                    options: $.extend({}, defOptions, options)
                });

                init(this);
            }
            // 设置当前dom样式
            $(this).css(state.options.css);
        })
    }

    // 初始化
    function init(target){
        initPanel(target);
        initEvent(target);
    }

    // 初始化事件
    function initEvent(target){
        $(target).click(function(event){
            currentTarget = target;
            loadValue(target);
            showTimePanel(target);
        });
    }

    // 创建面板
    function initPanel(target){
        if(!$timePanel){
            // 创建一个一行三列的表格
            var $table = createTable(target);

            $timePanel = createPanel($table);

            $('body').append($timePanel);
        }
    }

    function createTable(target){
        // 创建表格
        var $table = $(timeTablelHtml);
        var $subTables = $table.find('table');

        var $hourTable = $subTables.eq(0);
        var $minuteTable = $subTables.eq(1);

        $hourTDs = $hourTable.find('td');
        $minuteTDs = $minuteTable.find('td');

        initId($hourTDs,$minuteTDs);

        $hourTDs.click(function(){
            setHour($(this).html());
        });

        $minuteTDs.click(function(){
            setMinute($(this).html());
        });

        $table.find('a').click(function(){
            okHandler();
        });

        initCss($table,$hourTDs,$minuteTDs);

        return $table;
    }

    function initCss($table,$hourTDs,$minuteTDs){
        $table.css({'font-size':'16px','text-align':'center'});
        $table.find('hr')
            .css({height:'0px'
                ,'border-top':'1px solid #c8cacc'
                ,'border-right':'0px'
                ,'border-bottom':'0px'
                ,'border-left':'0px'});

        var $subTables = $table.find('table');

        $subTables.find('td').css({
            'cursor':'pointer'
            ,'font-size':'14px'
            ,'text-align':'center'
            ,'padding':'2px 4px 2px 4px'
        });

        $minuteTDs.css({'color':'#e02d2d'});

        $table.find('a').css({
            color: '#329ECC'
            ,'text-decoration': 'none'
        });
    }

    function setHour(val){
        $hourTDs.css({'background-color':'#fff'});
        getHourTD(val).css({'background-color':'#95b8e7'});
        currentTarget.hourVal = val;
    }

    function setMinute(val){
        $minuteTDs.css({'background-color':'#fff'});
        getMinuteTD(val).css({'background-color':'#95b8e7'});
        currentTarget.minuteVal = val;
    }

    function getHourTD(val){
        return $('#'+hourTdIdPrefix + val);
    }

    function getMinuteTD(val){
        return $('#'+minuteTdIdPrefix + val);
    }

    function initId($hourTDs,$minuteTDs){
        $hourTDs.each(function(){
            $(this).attr('id',hourTdIdPrefix + $(this).html());
        });
        $minuteTDs.each(function(){
            $(this).attr('id',minuteTdIdPrefix + $(this).html());
        });
    }

    function createPanel($table){
        var $panel =  $('<div class="timepick"></div>').css({
            display:"none"
            ,position:"absolute"
            ,'background-color':'#fff'
            ,border:'1px solid #ccc'
            ,'padding':'5px'
        });

        $panel.append($table);

        return $panel;
    }


    // 显示面板
    function showTimePanel(target){
        var targetOffset = $(target).offset();
        var timepick = $.data(target).timepick;

        $timePanel.offset({top: (targetOffset.top + timepick.options.offsetY)
            , left: (targetOffset.left + timepick.options.offsetX)});

        $timePanel.show();
    }

    // 关闭面板
    function hideTimePanel(){
        $timePanel.offset({top: 0, left: 0 });
        $timePanel.hide();
    }

    /**
     * 格式化日期<br>
     * 使用方法:
     * <code>
     * var dateStr = format(new Date(),'yyyy-MM-dd hh:mm:ss.S');
     * </code>
     *
     * @param dateInstance Date实例
     * @param 格式化字符串,如"yyyy-MM-dd","yyyy-MM-dd hh:mm:ss.S"
     *
     * @return 返回格式化后的字符串
     */
    function format(dateInstance,pattern) {
        var o = {
            "M+" : dateInstance.getMonth()+1,                 //月份
            "d+" : dateInstance.getDate(),                    //日
            "h+" : dateInstance.getHours(),                   //小时
            "m+" : dateInstance.getMinutes(),                 //分
            "s+" : dateInstance.getSeconds(),                 //秒
            "q+" : Math.floor((dateInstance.getMonth()+3)/3), //季度
            "S"  : dateInstance.getMilliseconds()             //毫秒
        };
        if(/(y+)/.test(pattern)) {
            pattern = pattern.replace(RegExp.$1, (dateInstance.getFullYear()+"").substring(4 - RegExp.$1.length));
        }

        for(var k in o) {
            if(new RegExp("("+ k +")").test(pattern)) {
                pattern = pattern.replace(RegExp.$1, (RegExp.$1.length == 1)
                    ? (o[k])
                    : (("00"+ o[k]).substring((""+ o[k]).length)));
            }
        }

        return pattern;
    }

    // 确定事件句柄
    function okHandler(){
        var currentTimepick = $.data(currentTarget).timepick;
        var onOK = currentTimepick.options.onOK;

        if($.isFunction(onOK)){
            var hourVal = currentTarget.hourVal || '0';
            var minuteVal = currentTarget.minuteVal || '0';
            // 格式化输出
            // 获取<select>标签,第一个是小时,第二个分
            var val = formatValue(currentTimepick.options.format,hourVal,minuteVal);
            onOK(val,$(currentTarget));
        }

        hideTimePanel();
    }

    function formatValue(formatStr,hourVal,minuteVal){
        // 借用Date对象赋值,进行后续的格式化
        date.setHours(hourVal); // 时
        date.setMinutes (minuteVal); // 分

        return format(date,formatStr);
    }

    function loadValue(target){
        var hourVal = target.hourVal || '00';
        var minuteVal = target.minuteVal || '00';

        setHour(hourVal);
        setMinute(minuteVal);
    }


    function formatNum(num){
        return num < 10 ? "0" + num : num;
    }

    // 点击空白地方隐藏面板
    $(document).click(function(e){
        if($timePanel){
            var obj = e.target;

            var isOutSide = $(obj).parents('.timepick').length == 0;
            var notCurrentTarget = (obj != currentTarget);
            // 鼠标点空白地方并且没有点在输入框上
            if(isOutSide && notCurrentTarget){
                hideTimePanel();
            }
        }
    });


})(jQuery);