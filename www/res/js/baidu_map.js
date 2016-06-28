var show_king_id = 1;
function show_king_list(e,k,baidumap_x,baidumap_y,title,linkurl)
{
    if(show_king_id == k) {
        e.className = " ";
        return true;
    }
        o = document.getElementById("k"+show_king_id);
        o.className = "ov";
    e.className = " ";
    show_king_id = k;
    bmap_goto(baidumap_x,baidumap_y,title,linkurl,k);
}
function bmap_goto(baidumap_x,baidumap_y,title,linkurl,k) {
    map.clearOverlays();
    var new_point = new BMap.Point(baidumap_x,baidumap_y);
    //var marker = new BMap.Marker(new_point);  // 创建标注
    //map.addOverlay(marker);              // 将标注添加到地图中
    map.panTo(new_point);
    var opts = {
        position : new_point,    // 指定文本标注所在的地理位置
        offset   : new BMap.Size(-10, 0)    //设置文本偏移量
    }
    var label = new BMap.Label('<a href="'+linkurl+'"><div id="dizhi1s"  class="mapword">'+k+'<span style="padding-left:8px;">'+title+'</span></div> </a>', opts);  // 创建文本标注对象
    label.setStyle({
        border : "0px",
        fontSize : "12px",
        height : "20px",
        lineHeight : "20px",
        backgroundColor : '',
        fontFamily:"微软雅黑"
    });
    map.addOverlay(label);
}

function bmap_all(baidumap_x,baidumap_y,title,num,linkurl) {
    var new_point = new BMap.Point(baidumap_x,baidumap_y);
    var opts = {
        position : new_point,    // 指定文本标注所在的地理位置
        offset   : new BMap.Size(-10, 0)    //设置文本偏移量
    }
    var label = new BMap.Label('<a href="'+linkurl+'"><div id="dizhi1s"  class="mapword">'+num+' <span style="padding-left:8px;">'+title+'</span></div> </a>', opts);  // 创建文本标注对象
    label.setStyle({
        border : "0px",
        fontSize : "12px",
        height : "20px",
        lineHeight : "20px",
        backgroundColor : '',
        fontFamily:"微软雅黑"
    });
    map.addOverlay(label);
}

var show_kinga_id = 1;
function show_kinga_list(f,l)
{
    if(show_kinga_id == l) return true;
        o = document.getElementById("o"+show_kinga_id);
        o.className = "ov";
    f.className = " ";
    show_kinga_id = l;
}