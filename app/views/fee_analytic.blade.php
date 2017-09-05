@extends('layouts.layout_not_jquery')
@section('head')
    <link type="text/css" rel="stylesheet" href="css/ui.notify.css"/>
    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
@endsection
@section('title')
    Thống kê chi phí hàng tháng
@endsection
@section('main_content')
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"><span class="icon"> <i class="icon-th"></i> </span>
                        <h5>Thống kê chi phí hàng tháng</h5>
                    </div>
                    <div class="widget-content tab-content">
                        <div class="tab-pane active">
                            <div class="tab-pane">
                                <div class="widget-content nopadding" style="border-bottom: none">
                                    <form action="/fee-analytic" method="get">
                                        <div class="control-group">

                                            <div class="controls">
                                                Từ: <input id="datetimepicker" class="span3" type="text"
                                                           name="from_date" value="{{@$from_date}}">
                                                Đến: <input id="datetimepicker1" class="span3" type="text"
                                                            name="to_date" value="{{@$to_date}}">
                                            </div>
                                            <div class="controls">
                                                <button type="submit" class="btn btn-success">Thống kê</button>
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
                                    <table class="table table-bordered table-striped" id="table_fee">
                                        <thead>
                                        <tr>
                                            <th style="min-width: 200px">Tên chi phí</th>
                                            <th>Số lượng</th>
                                            <th>Đơn giá</th>
                                            <th>Tổng(vnđ)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($fees as $key=>$value)
                                            <tr>
                                                <td><a href="/fee-details?id={{$value['cat_id']}}&from_date={{@$from_date}}&to_date={{@$to_date}}">{{$value['catalog_name']}}</a></td>
                                                <td><a href="/fee-details?id={{$value['cat_id']}}&from_date={{@$from_date}}&to_date={{@$to_date}}">{{number_format($value['amount'],0)}}</a></td>
                                                <td><a href="/fee-details?id={{$value['cat_id']}}&from_date={{@$from_date}}&to_date={{@$to_date}}">{{number_format($value['price'],0)}}/{{$value['unit']}}</a></td>
                                                <td><a href="/fee-details?id={{$value['cat_id']}}&from_date={{@$from_date}}&to_date={{@$to_date}}">{{number_format($value['sum_row'],0)}}</a></td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td style="text-align: right">Tổng (vnđ)</td>
                                            <td>
                                                {{number_format($sum,0)}}
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
    <script src="js/jquery.notify.js" type="text/javascript"></script>

    <script type="text/javascript">
        function create(template, vars, opts) {
            return $container.notify("create", template, vars, opts);
        }

        $(function () {
            $container = $("#container").notify();

        });
    </script>
    <script src="js/date-time-picker/jquery.js"></script>
    <script src="js/date-time-picker/jquery.datetimepicker.full.min.js"></script>
    <script>
        $.datetimepicker.setLocale('vi');
        $('#datetimepicker').datetimepicker({
            format: 'd-m-Y',
            timepicker: false,
        });
        $('#datetimepicker1').datetimepicker({
            format: 'd-m-Y',
            timepicker: false,
        });

    </script>
@endsection
