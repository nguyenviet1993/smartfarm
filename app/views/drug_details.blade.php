@extends('layouts.layout_not_jquery')
@section('head')
    <link type="text/css" rel="stylesheet" href="css/ui.notify.css"/>
    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
@endsection
@section('title')
    Thống kê chi tiết thuốc đã tiêu thụ
@endsection
@section('main_content')
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"><span class="icon"> <i class="icon-th"></i> </span>
                        <h5><a href="/drug-analytic?lake_id={{$lake_id}}&from_date={{$from_date}}&to_date={{$to_date}}"><i class="icon-arrow-left"></i></a> Thống kê chi tiết thuốc đã tiêu thụ &nbsp;<span style="color: red">{{$drug_name['category_name']}}</span></h5>
                    </div>
                    <div class="widget-content tab-content">
                        <div class="tab-pane active">
                            <div class="tab-pane">
                                <div class="widget-content nopadding">
                                    <table class="table table-bordered table-striped" id="table_fee">
                                        <thead>
                                        <tr>
                                            <th style="min-width: 200px">Tên ao nuôi</th>
                                            <th>Số lượng (Kg)</th>
                                            <th>Ngày nhập</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($drugs as $item)
                                            @if(@$item['amount'] != 0 )
                                                <tr>
                                                    <td>{{$item['lake_name']}}</td>
                                                    <td>{{$item['amount']}}</td>
                                                    <td>{{date('d-m-Y',$item['create_date'])}}</td>
                                                </tr>
                                            @endif
                                        @endforeach
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
