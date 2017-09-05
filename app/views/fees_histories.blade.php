@extends('layouts.layout_not_jquery')
@section('head')
    <link type="text/css" rel="stylesheet" href="css/ui.notify.css"/>
    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
@endsection
@section('title')
    Lịch sử chi phí hàng tháng
@endsection
@section('main_content')
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"><span class="icon"> <i class="icon-th"></i> </span>
                        <h5>Lịch sử chi phí hàng tháng</h5>
                    </div>
                    <div class="widget-content tab-content">
                        <div class="tab-pane active">
                            <div class="tab-pane">
                                <div class="widget-content nopadding" style="border-bottom: none">
                                    <form action="/histories-fees" method="get">
                                        <div class="control-group">
                                            <input type="text" class="span4" style="float: left; margin-right: 5px"
                                                   name="key" value="{{$key}}" onchange="submit(this.form)"/>
                                            <div class="controls">
                                                <input id="datetimepicker" class="span3" type="text" name="date" onchange="submit(this.form)"
                                                       value="{{@$select_date}}">
                                            </div>
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
                                    <table class="table table-bordered table-striped" id="table_fee">
                                        <thead>
                                        <tr>
                                            <th style="min-width: 200px">Tên chi phí</th>
                                            <th>Số lượng</th>
                                            <th>Giá (VNĐ)</th>
                                            <th style="min-width: 100px">Thành tiền (VNĐ)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($fee_catalogs as $catalog)
                                            <tr>

                                                <td>{{$catalog['catalog_name']}}</td>
                                                <td>
                                                    <label class="control-label" style="text-align: center">{{@$fees[$catalog['cat_id']]['amount']}}&nbsp; {{$catalog['unit']}}</label>
                                                </td>
                                                <td>
                                                    <label class="control-label" style="text-align: center">{{number_format(@$fees[$catalog['cat_id']]['price'],0)}}</label>
                                                </td>
                                                <td>
                                                    <label class="control-label"
                                                           id="SUMMARY_{{$catalog['cat_id']}}">{{number_format(@$fees[$catalog['cat_id']]['sum'],0)}}</label>
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

    </script>
@endsection
