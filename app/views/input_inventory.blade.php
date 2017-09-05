@extends('layouts.layout_not_jquery')
@section('head')
    <link type="text/css" rel="stylesheet" href="css/ui.notify.css" />
@endsection
@section('title')
    Nhập kho vật tư
@endsection
@section('main_content')
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"><span class="icon"> <i class="icon-th"></i> </span>
                        <h5>Nhập kho vật tư</h5>
                    </div>
                    <div class="widget-content tab-content" >
                        <div class="tab-pane active">
                            <div class="tab-pane">
                                <div class="widget-content nopadding" style="border-bottom: none">
                                    <form action="/input-inventory" method="get">

                                        <div class="control-group">
                                            <input type="text" class="span5" style="float: left; margin-right: 5px"
                                                   name="key" value="{{$key}}" onchange="submit(this.form)"/>
                                            <div class="controls">
                                                <button type="submit" class="btn">Tìm kiếm</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="widget-content tab-content">
                        <div class="tab-pane active">
                            <div class="tab-pane">
                                <div class="widget-content nopadding">
                                    <table class="table table-bordered table-striped"  id="table_inventory">
                                        <thead>
                                        <tr>
                                            <th style="min-width: 200px">Tên vật tư</th>
                                            <th style="min-width: 80px">Số lượng</th>
                                            <th style="min-width: 100px">Giá (VNĐ)</th>
                                            <th style="min-width: 100px">Thành tiền (VNĐ)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($catalogs as $catalog)
                                            <tr>
                                                <td>{{$catalog['catalog_name']}}</td>
                                                <td>
                                                    <input type="text" class="span5" id="AMOUNT_{{$catalog['cat_id']}}"
                                                           value="{{@$inventories[$catalog['cat_id']]['amount']}}"
                                                           onchange="changeValue('<?= $catalog['cat_id']?>')"/> &nbsp;{{$catalog['unit']}}
                                                </td>
                                                <td>
                                                    <input type="text" class="span10" id="PRICE_{{$catalog['cat_id']}}"
                                                           onchange="changeValue('<?= $catalog['cat_id']?>')"
                                                           value="{{number_format(@$inventories[$catalog['cat_id']]['price'],0)}}"
                                                           onkeyup="currency_format('<?= $catalog['cat_id']?>')"
                                                    />
                                                </td>
                                                <td>
                                                    <label class="control-label"
                                                           id="SUMMARY_{{$catalog['cat_id']}}">{{number_format(@$inventories[$catalog['cat_id']]['sum'],0)}}</label>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: right">Tổng</td>
                                            <td>
                                                <label class="control-label" id="TOTAL">{{number_format($total,0)}}</label>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="content">
        <!--- container to hold notifications, and default templates --->
        <div id="container" style="display:none">
            <div id="default">
                <h1>#{title}</h1>
                <p>#{text}</p>
            </div>
        </div>
    </div>
    <script src="js/jquery/jquery.js" type="text/javascript"></script>
    <script src="js/jquery/jquery-ui.js" type="text/javascript"></script>
    <script src="js/currency-format/jquery.priceformat.js"></script>
    <script>

        function currency_format(cat_id) {
            $('#PRICE_' + cat_id).priceFormat({
                prefix: '',
                thousandsSeparator: ',',
                centsLimit: 0,
                clearOnEmpty: true
            });
        }

        function changeValue(cat_id) {
            var amount = $('#AMOUNT_' + cat_id).val();
            var price = $('#PRICE_' + cat_id).val();
            price = parseFloat(price.replace(/,/g, ''));
            var sum = amount * price;
            var sum_format = sum.formatMoney(0, ',', '.');
            $('#SUMMARY_' + cat_id).html(sum_format);
            var total = 0;
            $('#table_inventory > tbody  > tr').each(function () {
                $(this).find("td:gt(0)").each(function () {

                    var value = $(this).find("label").html();
                    if (!isNaN(parseFloat(value))) {
                        var temp = parseFloat(value.replace(/,/g, ''));
                        total += temp;

                    }
                });
            });
            $('#TOTAL').html(numberWithCommas(total));
            var agrs = {
                url: "/input-inventory-action",
                type: "get",
                dateType: "text",
                data: {
                    price: price,
                    amount: amount,
                    cat_id: cat_id
                },
                success: function (result) {
//                    create("default", { title:'Thông báo', text:'Thành công!'});
                }
            };

            $.ajax(agrs);

        }

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        Number.prototype.formatMoney = function (decPlaces, thouSeparator, decSeparator) {
            var n = this,
                decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
                decSeparator = decSeparator == undefined ? "." : decSeparator,
                thouSeparator = thouSeparator == undefined ? "," : thouSeparator,
                sign = n < 0 ? "-" : "",
                i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
                j = (j = i.length) > 3 ? j % 3 : 0;
            return sign + (j ? i.substr(0, j) + thouSeparator : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator) + (decPlaces ? decSeparator + Math.abs(n - i).toFixed(decPlaces).slice(2) : "");
        };
    </script>

    <script src="js/jquery.notify.js" type="text/javascript"></script>

    <script type="text/javascript">
        function create( template, vars, opts ){
            return $container.notify("create", template, vars, opts);
        }

        $(function(){
            $container = $("#container").notify();

        });
    </script>
@endsection
