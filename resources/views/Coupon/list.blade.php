@extends('Coupon.public.layout')
@section('style')

@endsection
{{--@extends('Coupon.public.searchbar_navigation')--}}
{{--@extends('Coupon.public.color_block_area')--}}
{{--@extends('Coupon.public.condition_area')--}}
@section('tkl')
    {{$tkl}}
@endsection
@section('list')
    <div class="section-header">
        <div class="first">NEW</div>
        <div class="second">优惠券直播 (43464)</div>
    </div>
    <div class="goods-list">
        @foreach ($list as $coupon)
            <div class="goods">
                <div class="content block">

                    <a href="/view/item/{{$coupon['商品id']}}?gzh={{$gzh}}" target="_blank">
                        <div class="pic">
                            <img src="{{$coupon['商品主图']}}" class="lazy"
                                 data-original="{{$coupon['商品主图']}}">

                        </div>

                        <div class="today"></div>

                    </a>

                    <div class="info">

                        <div class="intro1">

                            <span class="mall-ico taobao"></span>

                            <a class="title" href="/view/item/{{$coupon['商品id']}}?gzh={{$gzh}}" target="_blank">{{$coupon['商品名称']}}</a>
                        </div>

                        <div class="intro2">
                            <span class="coupon">优惠券<span class="red">{{$coupon['优惠券面额']}}</span><!--，剩余8000张--></span>
                            <span class="sales"> 销量{{$coupon['商品月销量']}}</span>

                        </div>
                        <div class="intro3">
                <span class="price_discount red">¥ <span class="fee">


                        {{$coupon['商品价格(单位：元)']}}


                </span></span>
                        <span class="price_original">¥79

                </span>

                            <div class="tk right">
                <span class="campaign">

                </span>
                                <span class="commission red"><span class="fee">{{$coupon['优惠券面额']}}</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div style="clear:both"></div>
    </div>
    <div class="pagination">

        <ul class="pagination">
            <li class="disabled">
                <a href="#">
                    &laquo;
                </a>
            </li>


            <li class="active">
                <a href="/?page=1&amp;cateid=0">1</a>
            </li>


            <li>
                <a href="/?page=2&amp;cateid=0">2</a>
            </li>


            <li>
                <a href="/?page=3&amp;cateid=0">3</a>
            </li>


            <li>
                <a href="/?page=4&amp;cateid=0">4</a>
            </li>


            <li>
                <a href="/?page=5&amp;cateid=0">5</a>
            </li>


            <li class="disabled"><a href="#">&hellip;</a></li>


            <li>
                <a href="/?page=434&amp;cateid=0">434</a>
            </li>


            <li>
                <a href="/?page=435&amp;cateid=0">435</a>
            </li>


            <li>
                <a href="/?page=2&amp;cateid=0">
                    &raquo;
                </a>
            </li>
        </ul>

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

{{--@extends('Coupon.public.footer')--}}