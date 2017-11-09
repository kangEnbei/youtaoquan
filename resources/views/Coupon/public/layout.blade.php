<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <title></title>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    <!--小屏幕使用折叠效果-->
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=2.0, user-scalable=no">
    <!--优先使用最新浏览器内核渲染-->
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <meta name="renderer" content="webkit">
    <link rel="shortcut icon" href="" type="image/x-icon"/>

    <!--bootstrap的css和JS都用同一个域名下的文件，否则会因为跨域造成图标不显示-->

    <!--为了兼容IE8以及以下,请使用JQUERY1.9.0以及BOOTSTRAP3.2.0,之后的版本兼容性都逐步下降,
    JQ2.0完全不支持IE8,BOOTSTRAP3.3以后很多细节不兼容IE8-->
    <!--
     <link rel="stylesheet" href="http://cdn.bootcss.com/bootstrap/3.2.0/css/bootstrap.min.css">
     <script src="http://cdn.bootcss.com/jquery/1.9.0/jquery.min.js"></script>
     <script src="http://cdn.bootcss.com/jquery_lazyload/1.9.5/jquery.lazyload.min.js"></script>
     <script src="http://cdn.bootcss.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
     -->
    <!--
    <link rel="stylesheet" href="http://apps.bdimg.com/libs/bootstrap/3.2.0/css/bootstrap.min.css">
    <script src="http://apps.bdimg.com/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="http://apps.bdimg.com/libs/jquery-lazyload/1.9.5/jquery.lazyload.min.js"></script>
    <script src="http://apps.bdimg.com/libs/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    -->


    <link rel="stylesheet" href="http://static.taokemiao.com/static/ext/bootstrap/css/bootstrap.min.css">
    <script src="http://static.taokemiao.com/static/ext/jquery/1.9.0/jquery.min.js"></script>
    <script src="http://static.taokemiao.com/static/ext/jquery/jquery.lazyload.min.js"></script>
    <script src="http://static.taokemiao.com/static/ext/bootstrap/js/bootstrap.min.js"></script>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- 这些IE8兼容文件要和网站同域名才有效,放在本地最好 -->
    <!--[if lt IE 9]>
    <script src="http://static.taokemiao.com/static/ext/bootstrap/js/html5shiv.min.js"></script>
    <script src="http://static.taokemiao.com/static/ext/bootstrap/js/respond.min.js"></script>
    <![endif]-->

    <!--css放最后面，能覆盖booststrap的一些css属性，如字体-->
    <link rel="stylesheet" type="text/css" href="http://static.taokemiao.com/static/css/styles.css?v=2017070401">

    @yield('style')<!--自定义css-->

</head>
<body>
{{--<div class="top-bar hidden-xs">--}}
    {{--<div class="container">--}}
        {{--<span>--}}
            {{--淘客喵交流群：--}}
            {{--<a class="qun-num" target="_blank" href="https://jq.qq.com/?_wv=1027&k=4B4ZdKo">--}}
            {{--602873496--}}
            {{--</a>--}}
            {{--（验证语：淘客喵）--}}
        {{--</span>--}}
        {{--<span class="shop-cooperation">--}}
            {{--商务合作请加群：--}}
            {{--<a class="qun-num" target="_blank" href="https://jq.qq.com/?_wv=1027&k=46psejQ">605145730</a>（验证语：店铺名/团队名）--}}
        {{--</span>--}}
    {{--</div>--}}
{{--</div>--}}

@yield('searchbar_navigation')<!--搜索和导航-->

<div class="container">
    {{--<div style="display: none;">--}}
        {{--<img src="http://taokemiao-img.b0.upaiyun.com/big.png" alt="淘客喵">--}}
    {{--</div>--}}

@yield('color_block_area')<!--四个彩色大方块-->
@yield('condition_area')<!--分类-->
@yield('list')<!--列表-->
@yield('downplugin_tips')<!--未知-->
@yield('item')<!--详情-->
@yield('promotion_box')<!--未知-->
@yield('recommended_list')<!--推荐-->

    <div id="scrollTop"></div><!--返回顶部箭头-->
</div>

<script src="http://static.taokemiao.com/static/js/script.js?v=2017092501"></script>

<!--
<script src="//cdn.bootcss.com/moment.js/2.14.1/moment.min.js"></script>
<script src="//cdn.bootcss.com/moment.js/2.14.1/locale/zh-cn.js"></script>
-->

<!--
<script src="http://static.taokemiao.com/static/ext/moment/moment-with-locales.min.js"></script>
-->

<script src="http://static.taokemiao.com/static/ext/layer/layer.js"></script>

<script>
    var _hmt = _hmt || [];
    (function () {
        var hm = document.createElement("script");
        hm.src = "//hm.baidu.com/hm.js?7ba6298560fff1a6f6bf64b74ab6d56a";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>

<script>
    //初始化
    $(function () {
        $('.tab-home').addClass('active');
    });

    $('.filter-goods .minprice').val(getUrlArg("minprice"));
    $('.filter-goods .maxprice').val(getUrlArg("maxprice"));
    $('.filter-goods .sales').val(getUrlArg("sales"));

    //翻页加上筛选参数
    $('.pagination li a').each(function (i) {
        var link = $(this).attr('href');
        if (link.length > 10) {
            var newlink = link + "&minprice=" + getUrlArg("minprice") + "&maxprice=" + getUrlArg("maxprice") + "&sales=" + getUrlArg("sales");
            $(this).attr('href', newlink);
        }

    });
</script>

<script>
    function sort_goods(sort_name) {
        var url = location.href;
        if (url.indexOf("?") == -1)
            url += "?";
        var tmp = "";
        tmp = "sort=" + sort_name;
        url = url.indexOf("sort") > 0 ? url.replace(/sort=[0-9a-zA-Z-_]*/g, tmp) : url + "&" + tmp;
        //alert(url);
        location.href = url;
    }
    function filter_goods() {
        var url = location.href;
        if (url.indexOf("?") == -1)
            url += "?";
        if (url.indexOf("no_recommend=1") == -1)
            url += "&no_recommend=1";

        var tmp = "";
        tmp = "minprice=" + $('.filter-goods .minprice').val();
        url = url.indexOf("minprice") > 0 ? url.replace(/minprice=\d*/g, tmp) : url + "&" + tmp;

        tmp = "maxprice=" + $('.filter-goods .maxprice').val();
        url = url.indexOf("maxprice") > 0 ? url.replace(/maxprice=\d*/g, tmp) : url + "&" + tmp;

        tmp = "sales=" + $('.filter-goods .sales').val();
        url = url.indexOf("sales") > 0 ? url.replace(/sales=\d*/g, tmp) : url + "&" + tmp;

        location.href = url;
    }
</script>
@yield('footer')<!--底部-->
</body>
</html>