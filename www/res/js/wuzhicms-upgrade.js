function ProgressBar(option) {
    this.element = $(option.element);
    this.progressbar = $(option.element).find('.progress-bar');
    this.progresstext = $(option.element).find('.progress-text');
}

ProgressBar.prototype.setProgress = function(progress, text) {
    this.progressbar.css({
        width: progress + '%'
    });
    this.progresstext.html(text);

    if (progress >= 100) {
        this.completed();
    }
}

ProgressBar.prototype.reset = function() {
    this.progressbar.css({
        width: '0%'
    });
    this.progresstext.html('');
}

ProgressBar.prototype.show = function() {
    this.element.removeClass('hidden');
}

ProgressBar.prototype.hide = function() {
    this.element.addClass('hidden');
}

ProgressBar.prototype.active = function() {
    this.element.addClass('active');
}

ProgressBar.prototype.deactive = function() {
    this.element.removeClass('active');
}

ProgressBar.prototype.text = function(text) {
    this.progresstext.html(text);
}

ProgressBar.prototype.error = function(text) {
    this.progressbar.addClass('progress-bar-danger');
    this.progresstext.addClass('text-danger').html(text);
    this.deactive();
}

ProgressBar.prototype.recovery = function() {
    this.progressbar.removeClass('progress-bar-danger');
    this.progresstext.removeClass('text-danger').html('');
    this.active();
}

ProgressBar.prototype.completed = function() {
    this.deactive();
    this.progresstext.text('应用升级成功！');
    $("#updating-hint").hide();
    $("#finish-update-btn").show();
};

ProgressBar.prototype.hasError = function() {
    return this.progressbar.hasClass('progress-bar-danger');
}

function getQueue(urls) {
    var steps = [{
        title: '检查系统环境',
        url: urls.checkEnvironmentUrl,
        progressRange: [5, 20]
    }, {
        title: '下载安装升级程序',
        url: urls.downloadPackageUrl,
        progressRange: [25, 40]
    }, {
        title: '备份升级文件',
        url: urls.backupFileUrl,
        progressRange: [45, 60]
    }, {
        title: '处理模版文件',
        url: urls.proccessTemplateUrl,
        progressRange: [65, 80]
    }, {
        title: '执行安装升级程序',
        url: urls.beginUpgradeUrl,
        progressRange: [85, 100]
    }];
    return steps;
}

function makeErrorsText(title, errors) {
    var html = '<p>' + title + '<p>';
    html += '<ul>';
    $.each(errors, function(index, text) {
        html += '<li>' + text + '</li>';
    });
    html += '</ul>';
    return html;
}

function prepareUrl(url) {
    if (coveringUpdateTpl == true) {
        url = url + '&coveringUpdateTpl=' + coveringUpdateTpl;
        coveringUpdateTpl = false;
    }
    return url;
}

function exec(title, url, progressBar, startProgress, endProgress) {
    progressBar.setProgress(startProgress, '正在' + title);
    $.ajax(prepareUrl(url), {
        async: true,
        dataType: 'json',
        type: 'POST'
    }).done(function(data, jqXHR) {
        if (data.status == 'error') {
            progressBar.error(makeErrorsText(title + '失败：', data.errors));
        } else if (data.type == 'tpl') {
            tpl = data.response;
            tplist = data.response.join('<br/>');
            $(".tpl-package-upgrade").removeClass('hidden').find('span').html(tplist);
            $(".update-tpl-btn").on('click', function() {
                $(this).parents('.tpl-package-upgrade').addClass('hidden');
                coveringUpdateTpl = $(this).data('update');
                progressBar.setProgress(endProgress, title + '完成');
                $(document).dequeue('update_step_queue');
            })

        } else if (typeof(data.index) != "undefined") {
            if (url.indexOf('index') < 0) {
                url = url + '&index=0';
            }
            url = url.replace(/index=\d+/g, 'index=' + data.index);
            endProgress = startProgress + data.progress;
            if (endProgress > 100) {
                endProgress = 100;
            }
            progressBar.setProgress(endProgress, data.message + '完成');
            startProgress = endProgress;
            title = data.message;
            exec(title, url, progressBar, startProgress, endProgress);
        } else {
            progressBar.setProgress(endProgress, title + '完成');
            $(document).dequeue('update_step_queue');
        }
    }).fail(function(jqXHR, errorThrown) {
        progressBar.error(title + '时，发生了错误'+'<br>'+jqXHR.responseText);
        $(document).clearQueue('update_step_queue');
    });
}

var progressBar = new ProgressBar({
    element: '#package-update-progress',
    iframeId: '#iframeid'
});

var reloadOnClose = function() {
    $("#wuzhicms-upgrade").on('hidden.bs.modal', function() {
        window.location.reload();
    });
}


var $updateBtn = $(".btn-wuzhicms-upgrade");
var coveringUpdateTpl = false;

$updateBtn.click(function() {
    reloadOnClose();
    $updateBtn.hide();
    progressBar.show();
    $("#updating-hint").show();
    $(document).dequeue('update_step_queue');
});

$("#finish-update-btn").click(function() {
    $(this).button('loading').addClass('disabled');
    setTimeout(function() {
        window.location.reload();
    }, 2000);
});

var urls = $updateBtn.data();

var steps = getQueue(urls);

$.each(steps, function(i, step) {
    $(document).queue('update_step_queue', function() {
        exec(step.title, step.url, progressBar, step.progressRange[0], step.progressRange[1]);
    });
});