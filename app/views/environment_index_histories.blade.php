@extends('layouts.main_layout')
@section('title')
    Nhập thông tin trong ngày
@endsection
@section('head')
    <style>
        th, td {
            white-space: nowrap;
        }
    </style>
@endsection
@section('main_content')
    <style>
        .fixed-colum {
            width: 70px !important;
            position: absolute;
            margin-left: -15px;
            background: #EFEFEF !important;
            border-right: solid 1px #DDDDDD;
        }

        .fixed-row {
            width: 62px;
            position: absolute;
            margin-left: -15px;
            height: 40px !important;
            border-right: solid 1px #DDDDDD;
            background: #F9F9F9 !important;
        }
    </style>
    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="control-group">
                    <label class="control-label">Chọn ngày: </label>
                    <div class="controls">
                        <form method="get" action="/histories-environment-index">
                            <input id="datetimepicker" type="text" name="date" onchange="submit(this.form)"
                                   value="{{@$select_date}}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"><span class="icon"> <i class="icon-th"></i> </span>
                        <h5>Thông tin ngày <span style="color: red">{{@$select_date}}</span></h5>
                    </div>
                    {{--<div class="widget-title">--}}
                    <ul class="nav nav-tabs">
                        <?php $first = 0?>
                        @foreach($lakes as $key=>$value)
                            @if($first == 0)
                                <li class="active"><a data-toggle="tab" href="#tab{{$key}}">{{$value}}</a></li>
                                <?php $first = 1;?>
                            @else
                                <li><a data-toggle="tab" href="#tab{{$key}}">{{$value}}</a></li>
                            @endif
                        @endforeach
                    </ul>
                    {{--</div>--}}
                    <div class="widget-content tab-content">
                        @foreach($lakes as $key=>$value)
                            @if($first == 1)
                                <div id="tab{{$key}}" class="tab-pane active">
                                    <?php $first = 2?>
                                    @else
                                        <div id="tab{{$key}}" class="tab-pane">
                                            @endif
                                            <div class="widget-content nopadding">
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th>Lần</th>
                                                        @foreach($times as $time)
                                                            <th>{{$time['category_name']}}</th>
                                                        @endforeach
                                                    </tr>
                                                    </thead>
                                                    <tbody id='table_repeat_{{$key}}'>
                                                    @foreach($environments as $environment)
                                                        <tr class="odd gradeX">
                                                            <td>{{$environment['category_name']}}</td>

                                                            @foreach($times as $time)
                                                                <td>

                                                                    @if(@$index[$key.$environment['category_id'].$time['category_id']]['hour'] != 0)
                                                                        <label class="control-label text-center">
                                                                            {{@$index[$key.$environment['category_id'].$time['category_id']]['hour']}}
                                                                            h
                                                                            {{@$index[$key.$environment['category_id'].$time['category_id']]['minute']}}
                                                                            ' -
                                                                            {{@$index[$key.$environment['category_id'].$time['category_id']]['val']}}
                                                                        </label>
                                                                    @else
                                                                        <label>&nbsp;</label>
                                                                    @endif

                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                        @endforeach
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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