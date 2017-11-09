<?php
/**
 * Created by PhpStorm.
 * User: ningjian
 * Date: 2017/11/5
 * Time: 22:09
 */

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function clickStatistics(Request $request, $id)
    {
        //防重复
        if ($this->antiRepeat($request, $id)) {
            return;
        }
        $gzh = $request->input('gzh', '');
        if ($gzh) {
            return;
        }
        $this->increment($gzh, $id, 'click');
    }

    public function copyStatistics(Request $request, $id)
    {
        //防重复
        if ($this->antiRepeat($request, $id)) {
            return;
        }
        $gzh = $request->input('gzh', '');
        if ($gzh) {
            return;
        }
        $this->increment($gzh, $id, 'copy');
    }

    private function antiRepeat(Request $request, $id)
    {
        //用户的微信浏览器走的是腾讯的代理，目前不能判断是哪个用户发出的请求，所以目前很难判断是否存在刷点击量和刷复制量的问题
        //不过我们可以自己人为去刷或直接改Redis里的数值
        //永久返回false
        return false;
    }

    private function increment($gzh, $id, $cmd)
    {
        switch ($cmd) {
            case 'click':
                break;
            case 'copy':
                break;
            default:
                break;
        }
    }
}