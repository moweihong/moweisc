<div class="w_details_bottom">
    <!--最新上架-->

    <!--奖品详情-->
    <div class="w_calculate_results pgp">
        <div class="w_calculate_tabtit">
            <dl class="w_calculate_nav tabtit">
                <dd class="tabtita tabtita-on" id="goods_info" data-divshow="0">商品详情<i class="line"></i></dd>
                <dd class="tabtita" data-divshow="1" id="buy_record">所有参与记录<i class="line"></i></dd>
                <dd class="tabtita" data-divshow="2" id="show_record">晒单<i class="line"></i></dd>
            </dl>
        </div>
        <div class="ng-data-inner tabcon-box" style="display: block;">
            <!-- 商品详情 -->
            {!!$data['goods']['belongs_to_goods']['content']!!}
        </div>
        <!--所有参与记录-->
        <div class="w_prize_con c_newest_prize_con tabcon-box" id="product_buyrecord">
            <div class="w_clear"></div>
            <table class="w_yun_con" cellspacing="0" cellpadding="0">
                <tbody id="tbody_record">
                <tr>
                    <th>时间</th>
                    <th>昵称</th>
                    <th>参与人次</th>
                    <th>IP</th>
                    <th>来源</th>
                </tr>
                </tbody>
            </table>
            <!-- 分页 -->
            <div id="pro_page1"></div>
            <div class="w-msgbox m-detail-codesDetail" id="pro-view-9" style="z-index:10000;">
                <a data-pro="close" href="javascript:void(0);" class="w-msgbox-close"></a>
                <div class="w-msgbox-hd" data-pro="header">
                    <h3></h3>
                </div>
                <div class="w-msgbox-bd" data-pro="entry">
                    <div class="m-detail-codesDetail-bd">
                        <div class="m-detail-codesDetail-wrap">
                            <dl class="m-detail-codesDetail-list f-clear">
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!--晒单-->
        <div class="w_prize_con  c_newest_prize tabcon-box" id="product_show">

            <div id="pro_page2"></div>

        </div>

    </div>
    <div class="w_clear"></div>
</div>

<input type="hidden" value="{{$id}}" id="product_id"/>
<input type="hidden" value="{{config('global.base_url').config('global.ajax_path.product_buyrecord')}}" id="recordpath"/>
<input type="hidden" value="{{config('global.base_url').config('global.ajax_path.product_showrecord')}}" id="showpath"/>

<input type="hidden" id="curpage_show" value="1"/>
<input type="hidden" id="curpage_show_total" value="0"/>
<input type="hidden" id="curpage_show_totalpage" value="0"/>
<input type="hidden" id="curpage_show_pagesize" value="0"/>
<input type="hidden" id="curpage_show_isload" value="0"/>


<input type="hidden" id="curpage_record" value="1"/>
<input type="hidden" id="curpage_total" value="0"/>
<input type="hidden" id="curpage_totalpage" value="0"/>
<input type="hidden" id="curpage_pagesize" value="0"/>
<input type="hidden" id="curpage_isload" value="0"/>

<script type="text/javascript" src="{{ $url_prefix }}js/product.js"></script>
