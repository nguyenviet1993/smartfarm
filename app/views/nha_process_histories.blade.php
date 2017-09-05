@extends('layouts.main_layout')
@section('title')
    Nhập thông tin Nhá trong ngày
@endsection
@section('head')
    <style>
        th, td {
            white-space: nowrap;
        }


    </style>
    <style>
        .kv-avatar .file-preview-frame, .kv-avatar .file-preview-frame:hover {
            margin: 0;
            padding: 0;
            border: none;
            box-shadow: none;
            text-align: center;
        }

        .kv-avatar .file-input {
            display: table-cell;
            max-width: 220px;
        }
    </style>
    <link href="bootstrap-fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
@endsection
@section('main_content')
    <style>
        .fixed-column {
            width: 22px !important;
            position: absolute;
            margin-left: -15px;
            background: #EFEFEF !important;
            /*border-right: solid 1px #DDDDDD;*/
        }

        .fixed-row {
            width: 14px;
            position: absolute;
            height: 60px;
            margin-left: -15px;
            background: #F9F9F9 !important;
        }
    </style>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="control-group">
                    <label class="control-label">Chọn ngày: </label>
                    <div class="controls">
                        <form method="get" action="/histories-nha-process">
                            <input id="datetimepicker" type="text" name="date" onchange="submit(this.form)" value="{{@$select_date}}" >
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
                        <h5>Thông tin Nhá <span style="color: red">{{@$select_date}}</span></h5>
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
                                                @if(Session::has('success_add_eat'))
                                                    <div class="alert alert-success">{{Session::get('success_add_eat')}}</div>
                                                @endif
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th class="fixed-column">Lần</th>
                                                        <th></th>
                                                        <th>Thời gian bắt đầu Nhá</th>
                                                        <th>Ảnh Nhá</th>
                                                        <th>Thời gian Nhá</th>
                                                        <th>Kết luận</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id='table_repeat_{{$key}}'>

                                                    @for($j=0;$j<count(@$new_nha[$key]);$j++)
                                                        <tr class="odd gradeX" id='col_repeat_{{$key}}{{$j}}'>
                                                            <td class="fixed-row text-center">{{@$new_nha[$key][$j]['time']}}</td>
                                                            <td style="border-left: none"></td>
                                                            <td>
                                                                <label class="control-label text-center" >{{$new_nha[$key][$j]['hour']}}h {{$new_nha[$key][$j]['minute']}}'</label>
                                                            </td>
                                                            <td class="form-group" style="text-align: center">
                                                                <img src="{{@$new_nha[$key][$j]['image_url']}}"
                                                                     style="width: 180px"/>
                                                            </td>
                                                            <td>
                                                                <label class="control-label text-center">{{$new_nha[$key][$j]['duration']}} giờ</label>
                                                            </td>
                                                            <td style="min-width: 200px">
                                                                <label class="control-label text-center">{{$new_nha[$key][$j]['result']}}</label>
                                                            </td>
                                                        </tr>
                                                    @endfor
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