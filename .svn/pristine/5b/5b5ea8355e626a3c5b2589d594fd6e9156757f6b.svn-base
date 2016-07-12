/*
    像素格工作室 Pixel grid studio www.pxgrids.com
*/
// 登录页鼠标点选输入框效果
var pxgridsLogin = pxgridsLogin || {};
;(function($, window, undefined)
{
    "use strict";
    $(document).ready(function()
    {
        pxgridsLogin.$container = $("#form_login");
        // Focus Class
        pxgridsLogin.$container.find('.form-control').each(function(i, el)
        {
            var $this = $(el),
                $group = $this.closest('.input-group');
            
            $this.prev('.input-group-addon').click(function()
            {
                $this.focus();
            });
            $this.on({
                focus: function()
                {
                    $group.addClass('focused');
                },
                
                blur: function()
                {
                    $group.removeClass('focused');
                }
            });
        }); 
    });
})(jQuery, window);