;(function ($) {
    var $this;
    $(function () {
        $iColor = $('#iColorPicker').length ? $('#iColorPicker') : initColor();
        $(document).bind('click', function() {
            $iColor.is(':visible') && $iColor.fadeOut();
        });
    });

    function initColor() {
        var hx = [
            'f00', 'ff0', '0f0', '0ff', '00f', 'f0f', 'fff', 'ebebeb', 'e1e1e1', 'd7d7d7', 'ccc', 'c2c2c2', 'b7b7b7', 'acacac', 'a0a0a0', '959595',
            'ee1d24', 'fff100', '00a650', '00aeef', '2f3192', 'ed008c', '898989', '7d7d7d', '707070', '626262', '555', '464646', '363636', '262626', '111', '000',
            'f7977a', 'fbad82', 'fdc68c', 'fff799', 'c6df9c', 'a4d49d', '81ca9d', '7bcdc9', '6ccff7', '7ca6d8', '8293ca', '8881be', 'a286bd', 'bc8cbf', 'f49bc1', 'f5999d',
            'f16c4d', 'f68e54', 'fbaf5a', 'fff467', 'acd372', '7dc473', '39b778', '16bcb4', '00bff3', '438ccb', '5573b7', '5e5ca7', '855fa8', 'a763a9', 'ef6ea8', 'f16d7e',
            'ee1d24', 'f16522', 'f7941d', 'fff100', '8fc63d', '37b44a', '00a650', '00a99e', '00aeef', '0072bc', '0054a5', '2f3192', '652c91', '91278f', 'ed008c', 'ee105a',
            '9d0a0f', 'a1410d', 'a36209', 'aba000', '588528', '197b30', '007236', '00736a', '0076a4', '004a80', '003370', '1d1363', '450e61', '62055f', '9e005c', '9d0039',
            '790000', '7b3000', '7c4900', '827a00', '3e6617', '045f20', '005824', '005951', '005b7e', '003562', '002056', '0c004b', '30004a', '4b0048', '7a0045', '7a0026'
        ];

        var row = '', $iColorPicker = $('<div id="iColorPicker"><table class="pickerTable"><thead></thead><tbody><tr><td style="border:1px solid #000;background:#fff;cursor:pointer;height:60px;-moz-background-clip:-moz-initial;-moz-background-origin:-moz-initial;-moz-background-inline-policy:-moz-initial;" colspan="16" id="colorPreview"></td></tr></tbody></table></div>').css('display','none').appendTo($('body'));

        $iColorPicker.on({
            'mouseover': function(evt) {
                var hx = $(evt.target).attr('hx');
                hx != undefined && $('#colorPreview').css('background', '#' + hx).attr('hx', hx);
            },

            'click': function(evt) {
                var hx = $(evt.target).attr('hx');
                if (hx == undefined) {
                    evt.stopPropagation();
                    return false;
                }

                $this.callback($this, hx);
            }
        });

        $.each(hx, function(num, color) {
            row += '<td style="background:#' + color + '" hx="' + color + '"></td>';
            if (num % 16 == 15) {
                $('<tr>' + row + '</tr>').appendTo($iColorPicker.find('thead'));
                row = '';
            }
        });

        return $iColorPicker;
    }

    function coord($elem, $panel, num) {
        var offset = $elem.offset();
        num = $.extend({'x': 0, 'y': 0}, num);
        $panel.css({
            'top': offset.top + $elem.outerHeight() - $panel.outerHeight() + num.y + 'px',
            'left': offset.left + $elem.outerWidth() + num.x + 'px',
            'position': 'absolute'
        }).fadeIn('fast');
    }

    function setColor($em, hx) {
        var val = '#' + hx;
        $em[$em.attr('type') == undefined ? 'html' : 'val'](val).css('color', val).attr('hx', val);
    }

    $.fn.iColor = function(arg, set) {
        return this.each(function() {
            var $t = $(this), val = $t.attr('hx');
            if (val != undefined)
            {
                val = $.trim(val);
                if (val.indexOf('#') > -1) {
                    val = val.replace('#', '');
                }

                val.length && setColor($t, val + ['', '00', '0'][val.length % 3]);
            }

            $t.click(function(evt) {
                $this = $(evt.target);
                $this.callback =  arg || setColor;

                coord($t, $iColor, set);
                evt.stopPropagation();
            });
        });
    };
})(jQuery);

$(function()
{
    $('#title_color').iColor(function($elem, hx) {
       $("#title").css('color', '#' + hx);
       $("#title_css").val(hx);
    }, {'x': -202, 'y': 170});
});




