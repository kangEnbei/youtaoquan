@extends('Coupon.public.layout')
@section('style')

@endsection
{{--@extends('Coupon.public.searchbar_navigation')--}}
{{--@extends('Coupon.public.color_block_area')--}}
{{--@extends('Coupon.public.condition_area')--}}

@section('list')
    <div class="section-header">
        <div class="first">NEW</div>
        <div class="second">优惠券直播 (43464)</div>
    </div>
    <div class="goods-list">

        <div class="goods">
            <div class="content block">

                <a href="/detail/2138143" target="_blank">
                    <div class="pic">
                        <img src="http://static.taokemiao.com/static/images/waiting.png" class="lazy"
                             data-original="http://gaitaobao2.alicdn.com/tfscom/i3/2844174382/TB2x0mGawvD8KJjSsplXXaIEFXa_!!2844174382.jpg_290x290.jpg">

                    </div>

                    <div class="today"></div>

                </a>
                <div class="info">

                    <div class="intro1">

                        <span class="mall-ico taobao"></span>

                        <a class="title" href="/detail/2138143" target="_blank">冬季甜美可爱珊瑚绒韩版清新学生</a>
                    </div>

                    <div class="intro2">
                        <span class="coupon">优惠券<span class="red">20.0</span>元<!--，剩余8000张--></span>
                        <span class="sales"> 销量2549</span>

                    </div>
                    <div class="intro3">
                <span class="price_discount red">¥ <span class="fee">


                        39


                </span></span>
                        <span class="price_original">¥79

                </span>
                        <div class="tk right">
                <span class="campaign">

                </span>
                            <span class="commission red">佣金<span class="fee">30%</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


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
@endsection

{{--@extends('Coupon.public.footer')--}}