@extends('layouts.shop')
@section('title','购物车')
@section('content')
<body>
<div class="maincont">
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <h1>购物车</h1>
        </div>
    </header>
    <div class="head-top">
        <img src="/static/index/images/head.jpg" />
    </div><!--head-top/-->
    <table class="shoucangtab">
        <tr>
            <td width="75%"><span class="hui">购物车共有：<strong class="orange">2</strong>件商品</span></td>
            <td width="25%" align="center" style="background:#fff url(/static/index/images/xian.jpg) left center no-repeat;">
                <span class="glyphicon glyphicon-shopping-cart" style="font-size:2rem;color:#666;"></span>
            </td>
        </tr>
    </table>

    <div class="dingdanlist">
        <table>
            <tr>
                <td width="100%" colspan="4"><a href="javascript:;"><input type="checkbox" name="1" /> 全选</a></td>
            </tr>
            <tr>
                <td width="4%"><input type="checkbox" name="1" /></td>
                <td class="dingimg" width="15%"><img src="/static/index/images/pro1.jpg" /></td>
                <td width="50%">
                    <h3>三级分销农庄有机瓢瓜400g</h3>
                    <time>下单时间：2015-08-11  13:51</time>
                </td>
                <td align="right"><input type="text" class="spinnerExample" /></td>
            </tr>
            <tr>
                <th colspan="4"><strong class="orange">¥36.60</strong></th>
            </tr>
        </table>
    </div><!--dingdanlist/-->

    <div class="dingdanlist">
        <table>
            <tr>
                <td width="4%"><input type="checkbox" name="1" /></td>
                <td class="dingimg" width="15%"><img src="/static/index/images/pro1.jpg" /></td>
                <td width="50%">
                    <h3>三级分销农庄有机瓢瓜400g</h3>
                    <time>下单时间：2015-08-11  13:51</time>
                </td>
                <td align="right"><input type="text" class="spinnerExample" /></td>
            </tr>
            <tr>
                <th colspan="4"><strong class="orange">¥36.60</strong></th>
            </tr>
            <tr>
                <td width="100%" colspan="4"><a href="javascript:;"><input type="checkbox" name="1" /> 删除</a></td>
            </tr>
        </table>
    </div><!--dingdanlist/-->
    <div class="height1"></div>
    <div class="gwcpiao">
        <table>
            <tr>
                <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
                <td width="50%">总计：<strong class="orange">¥69.88</strong></td>
                <td width="40%"><a href="pay.html" class="jiesuan">去结算</a></td>
            </tr>
        </table>
    </div><!--gwcpiao/-->
</div><!--maincont-->
@endsection