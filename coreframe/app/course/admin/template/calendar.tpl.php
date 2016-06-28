<?php defined('IN_WZ') or exit('No direct script access allowed');?>
<?php
    include $this->template('header','core');
?>
<body>
<link href='/res/js/fullcalendar/fullcalendar.css' rel='stylesheet' />
<link href='/res/js/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='/res/js/fullcalendar/lib/moment.min.js'></script>

<script src='/res/js/fullcalendar/fullcalendar.min.js'></script>
<script src='/res/js/fullcalendar/lang/zh-cn.js'></script>
<link rel="stylesheet" type="text/css" href="/res/js/fancybox/jquery.fancybox.css">
<script src='/res/js/fancybox/jquery.fancybox.pack.js'></script>
<style>
    #calendar {
        max-width: 96%;
        margin: 0 auto;
        padding: 20px 10px;
    }
    .fc-row .fc-content-skeleton td, .fc-row .fc-helper-skeleton td {
        min-height: 100px;
    }
    .fc-content{cursor: pointer;}

    .fancy{width:280px; height:200px;}
    .fancy h3{height:30px; line-height:30px; border-bottom:1px solid #d3d3d3; font-size:14px}
    .fancy form{padding:10px}
    .fancy p{height:28px; line-height:28px; padding:4px; color:#3C3737;}
    .input{height:20px; line-height:20px; padding:2px; border:1px solid #d3d3d3; width:100px}
    .btn{-webkit-border-radius: 3px;-moz-border-radius:3px;padding:5px 12px; cursor:pointer}
    .btn_ok{background: #360;border: 1px solid #390;color:#fff}
    .btn_cancel{background:#f0f0f0;border: 1px solid #d3d3d3; color:#666 }
    .btn_del{background:#f90;border: 1px solid #f80; color:#fff }
    .sub_btn{height:32px; line-height:32px; padding-top:6px; border-top:1px solid #f0f0f0; text-align:right; position:relative}
    .sub_btn .del{position:absolute; left:2px}
</style>
<script>

    $(document).ready(function() {
        var currentLangCode = 'zh-cn';

        // build the language selector's options
        $.each($.fullCalendar.langs, function(langCode) {
            $('#lang-selector').append(
                $('<option/>')
                    .attr('value', langCode)
                    .prop('selected', langCode == currentLangCode)
                    .text(langCode)
            );
        });

        // rerender the calendar when the selected option changes
        $('#lang-selector').on('change', function() {
            if (this.value) {
                currentLangCode = this.value;
                $('#calendar').fullCalendar('destroy');
                renderCalendar();
            }
        });

        function renderCalendar() {
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                defaultDate: '<?php echo date('Y-m-d',SYS_TIME);?>',
                timeFormat: 'H:mm', // uppercase H for 24-hour clock
                contentHeight: 'auto',

                lang: currentLangCode,
                buttonIcons: false, // show the prev/next text
                weekNumbers: true,//是否显示第几周
                editable: false,
                minTime: "8:00:00",//最早时间限制
                maxTime: "18:00:00",//最晚时间限制
                slotDuration:'00:15:00',//间隔差
                slotLabelFormat:'h:mm',
                //hiddenDays:[ 0,6],//隐藏周几,Each index is zero-base (Sunday=0) and ranges from 0-6.
                eventLimit: false, // allow "more" link when too many events

                eventSources: [

                    // your event source
                    {
                        url: '/index.php',
                        type: 'POST',
                        data: {
                            id: '<?php echo $id;?>',
                            m: 'course',
                            f: 'json',
                            v: 'init'
                        },
                        error: function() {
                            alert('数据载入失败!!');
                        },
                        //color: '#6F99BD',   // a non-ajax option
                        textColor: '#fff' // a non-ajax option
                    }

                    // any other sources...

                ],
                eventClick: function(calEvent, jsEvent, view) {
                    $.fancybox({
                        'type': 'ajax',
                        'href': '/index.php?m=course&f=json&v=view&cdid=' + calEvent.cdid
                    });
                }
                /**
                events: [
                    {
                        title: 'All Day Event',
                        start: '2016-01-01'
                    },
                    {
                        title: 'Long Event',
                        start: '2016-01-07',
                        end: '2016-01-10'
                    },
                    {
                        id: 999,
                        title: 'Repeating Event',
                        start: '2016-01-09T16:00:00'
                    },
                    {
                        id: 999,
                        title: 'aaaaaaaaaaaaaa',
                        start: '2016-01-16T16:00:00',
                        url:'http://www.baidu.com',
                        color: '#ccc',   // a non-ajax option
                        //textColor: 'black' // a non-ajax option

                    },
                    {
                        title: 'Conference',
                        start: '2016-01-11',
                        end: '2016-01-13'
                    },
                    {
                        title: 'Meeting',
                        start: '2016-01-12T10:30:00',
                        end: '2016-01-12T12:30:00'
                    },
                    {
                        title: 'Lunch',
                        start: '2016-01-12T12:00:00'
                    },
                    {
                        title: 'Meeting',
                        start: '2016-01-12T14:30:00'
                    },
                    {
                        title: 'Happy Hour',
                        start: '2016-01-12T17:30:00'
                    },
                    {
                        title: 'Dinner',
                        start: '2016-01-12T20:00:00'
                    },
                    {
                        title: 'Birthday Party',
                        start: '2016-01-13T07:00:00'
                    },
                    {
                        title: 'Click for Google',
                        url: 'http://google.com/',
                        start: '2016-01-28'
                    }
                ]
                 **/
            });
        }

        renderCalendar();
    });

</script>


<section class="wrapper">
<!-- page start-->
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <?php echo $this->menu($GLOBALS['_menuid'],'&id='.$id);?>
            <header class="panel-heading">
                <a href="<?php echo $data['url'];?>" target="_blank"><?php echo $data['title'];?></a>
            </header>
            <div class="panel-body" id="panel-bodys">
                <div id='calendar'></div>
            </div>

        </section>
        </form>
    </div>
</div>
<!-- page end-->
</section>
<script src="<?php echo R;?>js/bootstrap.min.js"></script>
<script src="<?php echo R;?>js/jquery.nicescroll.js" type="text/javascript"></script>
<script src="<?php echo R;?>js/pxgrids-scripts.js"></script>
</body>
</html>