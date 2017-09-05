@extends('layouts.layout_not_jquery')
@section('head')
    <link type="text/css" rel="stylesheet" href="css/ui.notify.css"/>
    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
@endsection
@section('title')
    Thống kê thức ăn tiêu thụ
@endsection
@section('main_content')
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"><span class="icon"> <i class="icon-th"></i> </span>
                        <h5>Thống kê thức ăn tiêu thụ</h5>
                    </div>
                    <div class="widget-content tab-content">
                        <div class="tab-pane active">
                            <div class="tab-pane">
                                <div class="widget-content nopadding" style="border-bottom: none">
                                    <form action="/food-analytic" method="get">
                                        <div class="control-group">

                                            <div class="controls">
                                                <select name="lake_id">
                                                    <option value="default">Chọn ao nuôi</option>
                                                    @foreach($lakes as $lake)
                                                        @if($lake['lake_id'] == $lake_id)
                                                            <option value="{{$lake['lake_id']}}"
                                                                    selected>{{$lake['lake_name']}}</option>
                                                        @else
                                                            <option value="{{$lake['lake_id']}}">{{$lake['lake_name']}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
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
                                            <th style="min-width: 200px">Loại thức ăn</th>
                                            <th>Số lượng (Kg)</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @for($k=0;$k<7;$k++)
                                            <tr>
                                                <td><a href="/food-details?id={{$k}}&lake_id={{$lake_id}}&from_date={{@$from_date}}&to_date={{@$to_date}}">{{$k}}</a></td>
                                                <td><a href="/food-details?id={{$k}}&lake_id={{$lake_id}}&from_date={{@$from_date}}&to_date={{@$to_date}}">{{$foods[$k]}}</a></td>
                                            </tr>
                                        @endfor
                                        <tr>
                                            <td style="text-align: right">Tổng (Kg)</td>
                                            <td>
                                                {{$sum}}
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
