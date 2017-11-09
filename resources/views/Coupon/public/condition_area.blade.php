@section('condition_area')
    <div class="condition-area" id="condition-area">
        <ul class="categories">
            <li class="active"><a href="/">全部<!--(43464)--></a></li>

            <li class=""><a href="/?cateid=1">女装<!--(4852)--></a></li>

            <li class=""><a href="/?cateid=2">男装<!--(2781)--></a></li>

            <li class=""><a href="/?cateid=3">内衣<!--(2781)--></a></li>

            <li class=""><a href="/?cateid=4">鞋包<!--(3532)--></a></li>

            <li class=""><a href="/?cateid=5">配饰<!--(2059)--></a></li>

            <li class=""><a href="/?cateid=6">居家<!--(6888)--></a></li>

            <li class=""><a href="/?cateid=7">电器<!--(1016)--></a></li>

            <li class=""><a href="/?cateid=8">数码<!--(2241)--></a></li>

            <li class=""><a href="/?cateid=9">美食<!--(4078)--></a></li>

            <li class=""><a href="/?cateid=10">美妆<!--(3086)--></a></li>

            <li class=""><a href="/?cateid=11">母婴<!--(5035)--></a></li>

            <li class=""><a href="/?cateid=12">文体<!--(2992)--></a></li>

            <li class=""><a href="/?cateid=13">其他<!--(1389)--></a></li>

            <div class="cl-fix"></div>
        </ul>
        <ul class="sorts">
            <li>排序：</li>
            <li class="active">
                <a href="/?cateid=0">
                    默认
                </a>
            </li>
            <li class="">
                <a href="javascript:sort_goods('news')">
                    最新
                </a>
            </li>
            <li class="">
                <a href="javascript:sort_goods('sales-desc')">
                    销量最高
                </a>
            </li>
            <li class="">
                <a href="javascript:sort_goods('comm-rate-desc')">
                    佣金最高
                </a>
            </li>
            <li class="">
                <a href="javascript:sort_goods('price-asc')">
                    价格最低
                </a>
            </li>
            <li class="">
                <a href="javascript:sort_goods('price-desc')">
                    价格最高
                </a>
            </li>
            <li class="filter-goods" style="float: right;">
                <div style="display: inline-block; margin-right: 10px;">
                    价格
                    <input type="text" class="minprice" style="border:1px solid #ddd; width: 40px;height: 20px;"/>-
                    <input type="text" class="maxprice" style="border:1px solid #ddd; width: 40px;height: 20px;"/>
                </div>
                <div style="display: inline-block; margin-right: 10px;">
                    销量≥<input type="text" class="sales" style="border:1px solid #ddd; width: 40px;height: 20px;"/>
                </div>
                <div style="background-color: #a6e1ec; padding: 3px;display: inline-block; color: #fff; font-size: 12px; cursor: pointer; border-radius: 5px; margin-left: 5px;"
                     onclick="filter_goods()">筛选
                </div>
            </li>
            <div class="cl-fix"></div>
        </ul>
    </div>
@endsection