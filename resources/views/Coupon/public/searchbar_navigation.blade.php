@section('searchbar_navigation')
    <div class="logo-bar hidden-xs">
        <div class="container">
            <div class="logo hidden-sm"></div>
            <div class="search">
                <form action="/search-b?&next=http://www.taokemiao.com/">
                    <input class="search-wd" id="wd" name="wd" placeholder="找点东西" required="" type="text" value="">
                    <span class="input-group-btn">
                <input class="search-btn" type="submit" id="search-btn" value="搜索">
                </span>
                </form>
            </div>
        </div>
    </div>

    <div class="nav-bar hidden-xs">
        <div class="container">
            <div class="nav-tabs left">
                <a class="tab tab-home" href="/">优惠券直播</a>
                <a class="tab tab-hot" href="/hot">实时榜单</a>
                <a class="tab tab-tool" href="http://tool.taokemiao.com/">淘口令工具</a>
                <a class="tab tab-plugin hidden-sm" href="http://dl.taokemiao.com/" target="_blank">佣金插件</a>
                <a class="tab tab-plugin hidden-sm" href="http://soft.taokemiao.com/?nav" target="_blank">微信助手</a>
                <a class="tab tab-plugin hidden-sm" href="http://partner.taokemiao.com/?nav" target="_blank">代理分佣系统</a>
                <a class="tab tab-plugin hidden-sm" href="http://cms.taokemiao.com/?nav" target="_blank">CMS网站</a>
                <a class="tab tab-plugin hidden-sm" href="/help/miaowx" target="_blank">助手使用教程</a>
            </div>

            <div class="nav-tabs right">


                <a class="tab tab-register" href="/auth/register">注册</a>
                <a class="tab tab-login" href="/auth/login">登录</a>

            </div>
        </div>
    </div>
    <nav class="navbar navbar-inverse visible-xs" role="navigation">

        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/">淘客喵</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/">优惠券直播</a></li>
                    <li><a href="/hot">实时榜单</a></li>
                    <li><a href="http://tool.taokemiao.com/">淘口令工具</a></li>
                </ul>

                <form class="navbar-form navbar-left" role="search"
                      action="/search-b?&next=http://www.taokemiao.com/">
                    <div class="form-group">
                        <input type="text" class="form-control" id="wd" name="wd" placeholder="找点东西" required="">
                    </div>
                    <button type="submit" class="btn btn-default">搜索</button>
                </form>
                <ul class="nav navbar-nav navbar-right">


                    <li><a href="/auth/register">注册</a></li>
                    <li><a href="/auth/login">登录</a></li>

                </ul>
            </div><!-- /.navbar-collapse -->


        </div><!-- /.container-->
    </nav>
@endsection