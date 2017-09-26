<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimal-ui, user-scalable=no">
    <meta name="description" content="五指CMS程序安装">
    <meta name="author" content="wuzhicms.cn,Pixel grid studio">
    <title>WUZHICMS程序安装</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->

    <!--[if IE]>
    <div id="fuckie" class="text-warning fade in mb_0">
        <button data-dismiss="alert" class="close" type="button">×</button>
        <strong>WUZHICMS在谷歌浏览器下体验更好！速度更快！</strong> <a href="http://www.google.cn/intl/zh-CN/chrome/" target="_blank">点击下载谷歌浏览器</a>
    </div>
    <![endif]-->

    <!--[if lte IE 8]>
    <div id="fuckie" class="text-warning fade in mb_0">
        <button data-dismiss="alert" class="close" type="button">×</button>
        <strong>您正在使用低版本浏览器，</strong> 在本页面的显示效果可能有差异。建议您升级到<a href="http://www.google.cn/intl/zh-CN/chrome/" target="_blank">Chrome</a>
        或以下浏览器：<a href="https://www.mozilla.org/zh-CN/firefox/new/" target="_blank">Firefox</a> /<a href="http://www.apple.com.cn/safari/" target="_blank">Safari</a> /<a href="http://www.opera.com/" target="_blank">Opera</a> /<a href="http://windows.microsoft.com/zh-cn/internet-explorer/download-ie" target="_blank">Internet Explorer 11</a>
    </div>
    <![endif]-->
</head>
<body>
<section class="container">
    <!--main content start-->
    <section class="wrapper">
        <!-- page start-->
        <div class="wuzhicmsstep" id="bounceInLeft">
            <div class="col-lg-12">
                <section class="panel">
                    <div class="panel-body">
                        <div class="logo text-center"><a href="http://www.wuzhicms.com/" target="_blank"><span>五指CMS <?php echo $wz_version;?>安装五步曲</span></a></div>
                        <div class="stepy-tab text-center">
                            <ul id="default-titles" class="stepy-titles clearfix">
                                <li id="default-title-0" class="current-step">
                                    <div>安装须知</div>
                                </li>
                                <li id="default-title-1" class="">
                                    <div>环境检测</div>
                                </li>
                                <li id="default-title-2" class="">
                                    <div>账号配置</div>
                                </li>
                                <li id="default-title-3" class="">
                                    <div>正在安装</div>
                                </li>
                                <li id="default-title-4" class="">
                                    <div>安装完成</div>
                                </li>
                            </ul>
                        </div>
                        <form class="form-horizontal" id="default">
                            <fieldset class="step" id="default-step-0">
                                <legend> </legend>
                                <div class="licenseblock"><div class="license"><h4 class="text-center">WUZHICMS使用协议</h4>

                                        <p>版权所有 (c) 2014-2017，北京五指互联科技有限公司保留所有权利。</p>

                                        <p>感谢您选择WUZHICMS。希望我们的努力能为您提供一个高效快速、强大的跨屏网站整体解决方案，五指互联公司网址为 http://www.wuzhicms.com，产品官方讨论区网址为 http://bbs.wuzhicms.com。</p>

                                        <p>用户须知：本协议是您与五指互联公司之间关于您使用五指互联公司提供的各种软件产品及服务的法律协议。无论您是个人或组织、盈利与否、用途如何（包括以学习和研究为目的），均需仔细阅读本协议，包括免除或者限制五指互联责任的免责条款及对您的权利限制。请您审阅并接受或不接受本服务条款。如您不同意本服务条款及/或五指互联随时对其的修改，您应不使用或主动取消五指互联公司提供的WUZHICMS。否则，您的任何对WUZHICMS中的相关服务的注册、登陆、下载、查看等使用行为将被视为您对本服务条款全部的完全接受，包括接受五指互联对服务条款随时所做的任何修改。
                                        </p><p>本服务条款一旦发生变更, 五指互联将在网页上公布修改内容。修改后的服务条款一旦在网站管理后台上公布即有效代替原来的服务条款。您可随时登陆五指互联官方论坛查阅最新版服务条款。如果您选择接受本条款，即表示您同意接受协议各项条件的约束。如果您不同意本服务条款，则不能获得使用本服务的权利。您若有违反本条款规定，五指互联公司有权随时中止或终止您对WUZHICMS的使用资格并保留追究相关法律责任的权利。</p>
                                        <p>在理解、同意、并遵守本协议的全部条款后，方可开始使用WUZHICMS。您可能与五指互联公司直接签订另一书面协议，以补充或者取代本协议的全部或者任何部分。</p><p></p>

                                        <p>五指互联拥有本软件的全部知识产权。本软件只供许可协议，并非出售。五指互联只允许您在遵守本协议各项条款的情况下复制、下载、安装、使用或者以其他方式受益于本软件的功能或者知识产权。</p>

                                        <h3>I. 协议许可的权利</h3>
                                        <ol>
                                            &nbsp;  <li>您可以在完全遵守本许可协议的基础上，将本软件应用于非商业用途，而不必支付软件版权许可费用。</li>
                                            &nbsp;  <li>您可以在协议规定的约束和限制范围内修改WUZHICMS源代码(如果被提供的话)或界面风格以适应您的网站要求。</li>
                                            &nbsp;  <li>您拥有使用本软件构建的网站中全部会员资料、文章及相关信息的所有权，并独立承担与使用本软件构建的网站内容的审核、注意义务，确保其不侵犯任何人的合法权益，独立承担因使用五指互联软件和服务带来的全部责任，若造成五指互联公司或用户损失的，您应予以全部赔偿。</li>
                                            &nbsp;  <li>若您需将五指互联软件或服务用户商业用途，必须另行获得五指互联的书面许可，您在获得商业授权之后，您可以将本软件应用于商业用途，同时依据所购买的授权类型中确定的技术支持期限、技术支持方式和技术支持内容，自购买时刻起，在技术支持期限内拥有通过指定的方式获得指定范围内的技术支持服务。商业授权用户享有反映和提出意见的权力，相关意见将被作为首要考虑，但没有一定被采纳的承诺或保证。</li>
                                            &nbsp;  <li>您可以从五指互联提供的应用中心服务中下载适合您网站的应用程序，但应向应用程序开发者/所有者支付相应的费用。</li>
                                        </ol>

                                        <h3>II. 协议规定的约束和限制</h3>
                                        <ol>
                                            &nbsp;  <li>未获五指互联公司书面商业授权之前，不得将本软件用于商业用途（包括但不限于企业网站、经营性网站、以营利为目或实现盈利的网站）。购买商业授权请登陆http://www.wuzhicms.com参考相关说明，也可以致电8610-82463345了解详情。</li>
                                            &nbsp;  <li>不得对本软件或与之关联的商业授权进行出租、出售、抵押或发放子许可证。</li>
                                            &nbsp;  <li>无论如何，即无论用途如何、是否经过修改或美化、修改程度如何，只要使用WUZHICMS的整体或任何部分，未经书面许可，页面页脚处的WUZHICMS名称和五指互联公司下属网站（http://www.wuzhicms.com、或 http://bbs.wuzhicms.com） 的链接都必须保留，而不能清除或修改。</li>
                                            &nbsp;  <li>禁止在WUZHICMS的整体或任何部分基础上以发展任何派生版本、修改版本或第三方版本用于重新分发。</li>
                                            &nbsp;  <li>您从应用中心下载的应用程序，未经应用程序开发者/所有者的书面许可，不得对其进行反向工程、反向汇编、反向编译等，不得擅自复制、修改、链接、转载、汇编、发表、出版、发展与之有关的衍生产品、作品等。</li>
                                            &nbsp;  <li>如果您未能遵守本协议的条款，您的授权将被终止，所许可的权利将被收回，同时您应承担相应法律责任。</li>
                                        </ol>

                                        <h3>III. 有限担保和免责声明</h3>
                                        <ol>
                                            &nbsp;  <li>本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的。</li>
                                            &nbsp;  <li>用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未购买产品技术服务之前，我们不承诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任。</li>
                                            &nbsp;  <li>五指互联公司不对使用本软件构建的网站中或者论坛中的文章或信息承担责任，全部责任由您自行承担。</li>
                                            &nbsp;  <li>五指互联公司无法全面监控由第三方上传至应用中心的应用程序，因此不保证应用程序的合法性、安全性、完整性、真实性或品质等；您从应用中心下载应用程序时，同意自行判断并承担所有风险，而不依赖于五指互联公司。但在任何情况下，五指互联公司有权依法停止应用中心服务并采取相应行动，包括但不限于对于相关应用程序进行卸载，暂停服务的全部或部分，保存有关记录，并向有关机关报告。由此对您及第三人可能造成的损失，五指互联公司不承担任何直接、间接或者连带的责任。</li>
                                            &nbsp;  <li>五指互联公司对五指互联提供的软件和服务之及时性、安全性、准确性不作担保，由于不可抗力因素、五指互联公司无法控制的因素（包括黑客攻击、停断电等）等造成软件使用和服务中止或终止，而给您造成损失的，您同意放弃追究五指互联公司责任的全部权利。&nbsp;  6.五指互联公司特别提请您注意，五指互联公司为了保障公司业务发展和调整的自主权，五指互联公司拥有随时经或未经事先通知而修改服务内容、中止或终止部分或全部软件使用和服务的权利，修改会公布于五指互联公司网站相关页面上，一经公布视为通知。 五指互联公司行使修改或中止、终止部分或全部软件使用和服务的权利而造成损失的，五指互联公司不需对您或任何第三方负责。</li>
                                        </ol>

                                        <p>有关WUZHICMS最终用户授权协议、商业授权与技术服务的详细内容，均由五指互联公司独家提供。五指互联公司拥有在不事先通知的情况下，修改授权协议和服务价目表的权利，修改后的协议或价目表对自改变之日起的新授权用户生效。</p>

                                        <p>一旦您开始安装WUZHICMS，即被视为完全理解并接受本协议的各项条款，在享有上述条款授予的权利的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。</p>

                                        <p>本许可协议条款的解释，效力及纠纷的解决，适用于中华人民共和国大陆法律。</p>

                                        <p>若您和五指互联之间发生任何纠纷或争议，首先应友好协商解决，协商不成的，您在此完全同意将纠纷或争议提交五指互联所在地北京市海淀区人民法院管辖。五指互联公司拥有对以上各项条款内容的解释权及修改权。</p>

                                        <p>（正文完）</p>

                                        <p class="text-right">五指互联公司</p>

                                    </div></div>
                                <div class="text-center stepbtn"><a href="index.php?step=2" class="btn btn-info btn-shadow btn-step">开始安装</a></div>

                            </fieldset>
                        </form>
                    </div>
                </section>
            </div>
        </div>
        <!-- page end-->
    </section>
</section>
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
