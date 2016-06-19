function ProgressBar(option) {
    this.element = $(option.element);
    this.progressbar = $(option.element).find('.progress-bar');
    this.progresstext = $(option.element).find('.progress-text');
}

ProgressBar.prototype.setProgress = function (progress, text) {
    this.progressbar.css({width: progress + '%'});
    this.progresstext.html(text);

    if (progress >= 100) {
        this.completed();
    }
}

ProgressBar.prototype.reset = function () {
    this.progressbar.css({width: '0%'});
    this.progresstext.html('');
}

ProgressBar.prototype.show = function () {
    this.element.removeClass('hidden');
}

ProgressBar.prototype.hide = function () {
    this.element.addClass('hidden');
}

ProgressBar.prototype.active = function () {
    this.element.addClass('active');
}

ProgressBar.prototype.deactive = function () {
    this.element.removeClass('active');
}

ProgressBar.prototype.text = function (text) {
    this.progresstext.html(text);
}

ProgressBar.prototype.error = function (text) {
    this.progressbar.addClass('progress-bar-danger');
    this.progresstext.addClass('text-danger').html(text);
    this.deactive();
}

ProgressBar.prototype.recovery = function () {
    this.progressbar.removeClass('progress-bar-danger');
    this.progresstext.removeClass('text-danger').html('');
    this.active();
}

ProgressBar.prototype.completed = function () {
    this.deactive();
    this.progresstext.text('应用安装/升级成功！');
    $("#updating-hint").hide();
    $("#finish-update-btn").show();
};

ProgressBar.prototype.hasError = function () {
    return this.progressbar.hasClass('progress-bar-danger');
}

function getQueue(urls) {
    var steps = [
        {
            title: '检查系统环境',
            url: urls.checkEnvironmentUrl,
            progressRange: [3, 20]
        },
        {
            title: '备份系统文件',
            url: urls.backupFileUrl,
            progressRange: [23, 30]
        },
        {
            title: '备份数据库',
            url: urls.backupDbUrl,
            progressRange: [33, 40]
        },
        {
            title: '下载安装升级程序',
            url: urls.downloadExtractUrl,
            progressRange: [53, 60]
        },
        {
            title: '执行安装升级程序',
            url: urls.beginUpgradeUrl,
            progressRange: [62, 100]
        },
    ];
    return steps;
}


function makeErrorsText(title, errors) {
    var html = '<p>' + title + '<p>';
    html += '<ul>';
    $.each(errors, function (index, text) {
        html += '<li>' + text + '</li>';
    });
    html += '</ul>';
    return html;
}

function exec(title, url, progressBar, startProgress, endProgress) {
    progressBar.setProgress(startProgress, '正在' + title);
    $.ajax(url, {
        async: true,
        dataType: 'json',
        type: 'POST'
    }).done(function (data, jqXHR) {
        if (data.status == 'error') {
            progressBar.error(makeErrorsText(title + '失败：', data.errors));
        } else if (typeof (data.index) != "undefined") {
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
    }).fail(function (jqXHR, errorThrown) {
        progressBar.error(title + '时，发生了未知错误。');
        $(document).clearQueue('update_step_queue');
    });
}

var progressBar = new ProgressBar({
    element: '#package-update-progress',
    iframeId: '#iframeid'
});


var $updateBtn = $(".btn-wuzhicms-upgrade");

$updateBtn.click(function () {
    $updateBtn.hide();
    progressBar.show();
    $("#updating-hint").show();
    $(document).dequeue('update_step_queue');
});

$("#finish-update-btn").click(function () {
    $(this).button('loading').addClass('disabled');
    setTimeout(function () {
        window.location.reload();
    }, 3000);
});

var urls = $updateBtn.data();

var steps = getQueue(urls);

$.each(steps, function (i, step) {
    $(document).queue('update_step_queue', function () {
        exec(step.title, step.url, progressBar, step.progressRange[0], step.progressRange[1]);
    });
});

$("#wuzhicms-upgrade").on('hidden.bs.modal', function () {
    console.log('wuzhicms-upgrade');
});
