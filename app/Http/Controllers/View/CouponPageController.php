<?php

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CouponPageController extends Controller
{
    public function list(Request $request, $id=4)
    {
//        if (view()->exists('Coupon.list')) {
//            return view('Coupon.list', ['list' => %list]);
//        }
        return view('Coupon.list');
//
        echo $this->transmitHTML($id);
    }

    public function item(Request $request, $id=4)
    {
//        if (view()->exists('Coupon.list')) {
//            return view('Coupon.list', ['list' => %list]);
//        }
        return view('Coupon.list');
//
        echo $this->transmitHTML($id);
    }

    private function transmitHTML($id)
    {
        $template = '<html>
<style>
html,body{  
    height: 10000px;
    width: 10000px;
} 
</style>
<body data-clipboard-text="【好方生活馆】天猫双11预售主会场火热开启！上亿红包大放送，复制此信息{￥xmp906jFmye￥}或点击https://s.click.taobao.com/LgwqWYw打开淘宝，最高可抢1111元，百分百领到哦">
<ul>
<li onclick="ddd(this)">eeeee</li>
</ul>
</body>
<script src="https://cdn.bootcss.com/clipboard.js/1.7.1/clipboard.min.js"></script>
<script>
window.onload=function(){
    var clipboard = new Clipboard("body");
}
function ddd(target) {
  target.select;
  document.execCommand("Copy");
}
</script>
</html>';
        $HTML = sprintf($template, $id);
        return $HTML;
    }
}
