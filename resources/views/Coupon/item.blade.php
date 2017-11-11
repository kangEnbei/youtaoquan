@extends('Coupon.public.layout')
@section('style')
<link rel="stylesheet" type="text/css" href="http://static.taokemiao.com/static/css/detail.css?v=2017010402">
@endsection
{{--@extends('Coupon.public.searchbar_navigation')--}}
{{--@extends('Coupon.public.color_block_area')--}}

{{--@section('downplugin_tips')--}}
    {{--<div class="downplugin-tips hide">--}}
        {{--<a href="http://dl.taokemiao.com" target="_blank">--}}
            {{--<div class="banner-top-1140 hidden-xs">--}}
                {{--<img src="http://taokemiao-img.b0.upaiyun.com/banner/plugin-start2.jpg">--}}
            {{--</div>--}}
            {{--<!----}}
            {{--<div class="banner-top-mobile visible-xs">--}}
                {{--<img src="http://taokemiao-img.b0.upaiyun.com/banner/baiwantaokouling-mobile.jpg">--}}
            {{--</div>--}}
            {{---->--}}
        {{--</a>--}}
    {{--</div>--}}
{{--@endsection--}}
@section('tkl')
    {{$item['淘口令']}}
@endsection
@section('item')
    <div class="detail">
        <!--time:2017-11-09 10:21:01-->
        <span class="item-id" attr="559908291338"></span>
        <span class="extensions-data" itemid="559908291338"
              pid=""
              rate-type="3"
        ></span>
        <span class="extensions-args" itemid="559908291338"
              title="{{$item['商品名称']}}"
              pid=""
              rate-type="3"
              combo-url="https://uland.taobao.com/coupon/edetail?activityId=37913c846bfa479f864273f182273dd9&amp;itemId=559908291338&amp;mt=1&amp;src=tkm_tkmwz"
        ></span>
        <span class="extensions-response"></span>
        <div class="image col-sm-4">
            <img src="{{$item['商品主图']}}">
        </div>
        <div class="intro col-sm-8">
            <div class="title">

                <span class="mall-ico tmall"></span>

                <span>{{$item['商品名称']}}</span>
            </div>

            <div class="desc">{{$item['优惠券面额']}}</div>

            <div class="price">
                <span class="price-discount">券后价<span class="red">¥<span class="price-discount-val">79.9</span></span></span>

                &nbsp;&nbsp;&nbsp;<span>原价¥<span class="price-original-val">99.9</span> &nbsp;&nbsp;&nbsp;销量513</span>

                <div class="some-btn">
                    <a class="go" href="javascript:alert('复制成功,点击打开手机淘宝，即可领取');" target="_blank">复制优惠券</a>
                    {{--<div class="add-fav">收藏</div>--}}
                </div>
            </div>

            <div class="coupon">
                优惠券<span class="red">{{$item['优惠券面额']}}</span><!--，剩余<span
                    class="coupon-surplus">{{$item['优惠券剩余量']}}</span>张-->，{{$item['优惠券结束时间']}}过期
                <a href="{{$item['优惠券剩余量']}}" target="_blank">点击打开手机淘宝，即可领取</a>
            </div>

            {{--<div class="tk">--}}
                {{--<span class="rate red">佣金<span class="tk-rate-val">20.5</span>%</span>--}}


                {{--<span class="campaign campaign-0 hide">--}}
                    {{--<span class="campaign-name">通用计划</span>--}}
                    {{--<span>免申请</span>--}}
                {{--</span>--}}

                {{--<span class="campaign campaign-2 hide">--}}
                    {{--<span class="campaign-name">鹊桥活动</span>--}}
                    {{--<span>免申请</span>--}}
                {{--</span>--}}

                {{--<span class="campaign campaign-3 ">--}}
                    {{--<span class="campaign-name">营销计划</span>--}}
                    {{--<span>免申请</span>--}}
                {{--</span>--}}

                {{--<span class="campaign campaign-1 hide">--}}
                    {{--<span class="campaign-name">定向计划</span>--}}
                    {{--<span>秒过</span>--}}




                {{--</span>--}}



            {{--</div>--}}

            {{--<div class="plugin-bar-content"></div>--}}

            {{--<div class="copywriting" has-transform="0">--}}
                {{--微信/QQ群推广文案--}}
                {{--<div class="config-pid">--}}

                    {{--<span class="pid-name">--}}

                    {{--</span>--}}
                    {{--PID：--}}


                    {{--无--}}
                    {{--<span class="button click-pid-btn">--}}
                        {{--<span class="glyphicon glyphicon-cog"></span>--}}
                            {{--设置淘宝联盟PID</span>--}}


                {{--</div>--}}
                {{--<!----}}

                    {{--<img src="http://taokemiao-img.b0.upaiyun.com/goods/201711/6c2be6c402a01a92.jpg!300x300"><br>--}}

                {{---->--}}
                {{--<div class="content" id="copywriting-content">--}}
                    {{--<img src="http://gaitaobao4.alicdn.com/tfscom/i2/2843105094/TB1VK4tlbsTMeJjy1zcXXXAgXXa_!!0-item_pic.jpg"><br>--}}

                    {{--猫人保暖内衣女情侣本命年套装<br>--}}

                    {{--原价99.9元，--}}

                    {{--领券后【79.9元】包邮<br>--}}
                    {{--<div id="text-tkl"></div>--}}
                    {{--<div id="text-url" style="width: 100%">--}}

                        {{--20.0元内部券: <a href="http://shop.m.taobao.com/shop/coupon.htm?seller_id=2843105094&amp;activity_id=37913c846bfa479f864273f182273dd9" target="_blank">http://shop.m.taobao.com/shop/coupon.htm?seller_id=2843105094&amp;activity_id=37913c846bfa479f864273f182273dd9</a><br>--}}

                        {{--下单链接: <a href="https://detail.tmall.com/item.htm?id=559908291338" target="_blank">https://detail.tmall.com/item.htm?id=559908291338</a><br>--}}
                    {{--</div>--}}

                    {{--猫人天猫正品，，柔软透气，细腻亲肤，绝不褪色，超弹耐洗耐穿，情侣本命年套装，寒冷不等待！！！<br>--}}

                {{--</div>--}}
                {{--<!----}}
                {{--<div class="mobile-select-copy-tips visible-xs">--}}
                    {{--<span>手指长按框内文案 > 拷贝或复制</span>--}}
                {{--</div>--}}
                {{---->--}}

                {{--<span class="button transform-copywriting-btn">转链生成文案</span>--}}
                {{--<span class="button copy-copywriting-btn">--}}
                    {{--<span class="glyphicon glyphicon-file"></span>--}}
                    {{--复制文案--}}
                {{--</span>--}}
                {{--<a class="button edit-copy-template-btn right" href="/user/edit-copy-template">编辑文案模板</a>--}}
            {{--</div>--}}

            {{--<div class="hide">--}}
                {{--<span class="red">[公告] </span>这几天<span class="red">阿里妈妈官方淘口令接口到了晚上就开始维护</span>，所以网站生成没有淘口令。解决办法：下载安装淘客喵微信助手，不受影响。--}}
                {{--<a class="hidden-xs" href="http://soft.taokemiao.com" target="_blank">点此安装淘客喵微信助手</a>--}}
                {{--<br><br>--}}
            {{--</div>--}}


            {{--<div class="tkl-surplus hide">--}}
                {{--<span class="tkl-surplus-text"></span>--}}

                {{--<div>--}}
                    {{--您还未登录，登录后可以使用更多淘口令次数哦！--}}
                    {{--<a href="/auth/login?next=http%3A%2F%2Fwww.taokemiao.com%2Fdetail%2F2136139">点击这里登录</a>--}}
                {{--</div>--}}



            {{--</div>--}}

            <!--
            <div class="visible-xs">
                温馨提示: 由于手机系统限制,手机上使用需要将图片单独保存下载后发出去,然后再发文案。
            </div>
            -->


            {{--<div class="red hide">--}}
                {{--公告：--}}
                {{--<a href="http://taokemiao-img.b0.upaiyun.com/temp/alimama_dx_error.png" target="_blank">查看阿里官方公告</a>--}}
            {{--</div>--}}


            {{--<div class="help">--}}
                {{--<div>新手必读：</div>--}}
                {{--<div>点击 [生成我的文案] 蓝色按钮，自动生成商品软文+二合一淘口令+二合一短链接。</div>--}}
                {{--<div>如果无法生成文案或者无法复制文案，电脑上请使用360极速浏览器试试</div>--}}
                {{--<div>--}}
                    {{--如果需要拿到定向高佣金，每个商品都需要点击“申请高佣计划”，在弹出的阿里妈妈页面中点“申请推广”，--}}
                    {{--提交申请即可，申请会自动通过，无需等待。最后再来回到淘客喵生成文案。--}}
                    {{--<a href="http://taokemiao-img.b0.upaiyun.com/detail-how-to-use.jpg" target="_blank">[点击查看教程图]</a>--}}
                {{--</div>--}}
                {{--<div>想解放双手，想自动发群，自动发优惠券，请购买<a href="http://weixin.taokemiao.com/?f=detail-help" target="_blank">淘客喵微信助手</a>。</div>--}}
            {{--</div>--}}

        </div>
        <div style="clear:both"></div>
    </div>

    <script>
        window.onload=function(){
            var clipboard = new Clipboard("body");
        }

        function log(s){
            document.getElementById("contid").innerHTML = s;
            var clipboard = new Clipboard("body");
        }

        var eva = new zyEvent(document,'up',function(){log('向上滑动')});
        var evb = new zyEvent(document,'down',function(){log('向下滑动')});
        var evc = new zyEvent(document,'left',function(){log('向左滑动')});
        var evd = new zyEvent(document,'right',function(){log('向右滑动')});
    </script>
@endsection

{{--@section('promotion_box')--}}
    {{--<!--modal-->--}}
    {{--<div id="promotion-box" style="display: none;">--}}
        {{--<div class="title">选择需要使用的推广位PID</div>--}}
        {{--<div class="chooses">--}}

            {{--<div style="clear: both"></div>--}}
            {{--<div class="current-pid">当前PID：<br>--}}

            {{--</div>--}}
        {{--</div>--}}
        {{--<div>--}}
            {{--<a class="manage-pid-btn" href="/user/pid-setting">管理PID</a>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--@endsection--}}

{{--@section('recommended_list')--}}
    {{--<div class="section-header">--}}
        {{--<div class="first">LIKE</div><div class="second">随便看看</div>--}}
    {{--</div>--}}
    {{--<div>--}}
        {{--<div class="goods">--}}
            {{--<div class="content block">--}}

                {{--<a href="/detail/2090511" target="_blank">--}}
                    {{--<div class="pic">--}}
                        {{--<img src="http://static.taokemiao.com/static/images/waiting.png" class="lazy" data-original="http://gaitaobao2.alicdn.com/tfscom/i3/2303855627/TB2ey85Xz3z9KJjy0FmXXXiwXXa_!!2303855627.jpg_290x290.jpg">--}}

                    {{--</div>--}}

                {{--</a>--}}
                {{--<div class="info">--}}

                    {{--<div class="intro1">--}}

                        {{--<span class="mall-ico taobao"></span>--}}

                        {{--<a class="title" href="/detail/2090511" target="_blank">陈年普洱茶古树熟茶七子饼茶具冲泡</a>--}}
                    {{--</div>--}}

                    {{--<div class="intro2">--}}
                        {{--<span class="coupon">优惠券<span class="red">60.0</span>元<!--，剩余1000张--></span>--}}
                        {{--<span class="sales"> 销量1</span>--}}

                    {{--</div>--}}
                    {{--<div class="intro3">--}}
                {{--<span class="price_discount red">¥ <span class="fee">--}}


                        {{--39--}}


                {{--</span></span>--}}
                        {{--<span class="price_original">¥99--}}

                {{--</span>--}}
                        {{--<div class="tk right">--}}
                {{--<span class="campaign">--}}
                    {{--通用--}}

                {{--</span>--}}
                            {{--<span class="commission red">佣金<span class="fee">35%</span></span>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--@endsection--}}