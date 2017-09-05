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
            width: 15px;
            position: absolute;
            margin-left: -15px;
            height: 40px !important;
            /*border-right: solid 1px #DDDDDD;*/
            background: #F9F9F9 !important;
        }
    </style>
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="control-group">
                    <label class="control-label">Chọn ngày: </label>
                    <div class="controls">
                        <form method="get" action="/histories-nurturing-process">
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
                                                @if(Session::has('success_add_eat'))
                                                    <div class="alert alert-success">{{Session::get('success_add_eat')}}</div>
                                                @endif
                                                <table class="table table-bordered table-striped">
                                                    <thead>
                                                    <tr>
                                                        <th class="fixed-column">Lần</th>
                                                        <th></th>
                                                        <th>Thời gian</th>
                                                        <th>Số lượng thức ăn</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id='table_repeat_{{$key}}'>
                                                    @for($j=0;$j<count(@$new_foods[$key]);$j++)
                                                        <tr class="odd gradeX"
                                                            id='col_repeat_{{$new_foods[$key][$j]['lake_id']}}{{$new_foods[$key][$j]['time']}}'>
                                                            <td class="fixed-row">{{$new_foods[$key][$j]['time']}}</td>
                                                            <td></td>
                                                            <td>
                                                                <label class="control-label" style="text-align: center">{{$new_foods[$key][$j]['hour']}}h {{$new_foods[$key][$j]['minute']}}'</label>
                                                            </td>
                                                            <td class="form-group">
                                                                <label class="control-label" style="text-align: center">{{$new_foods[$key][$j]['food_val_1']+$new_foods[$key][$j]['food_val_2']}}Kg
                                                                    - Loại {{$new_foods[$key][$j]['food_type_id']=='default'?'Số':$new_foods[$key][$j]['food_type']}}</label>
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="control-group" style="margin-left: 17px">
                                                <h4>Chú ý</h4>
                                                <div class="controls">
                                                    <label class="control-label" for="inputWarning">
                                                        {{@$notes[$key]}}
                                                    </label>
                                                </div>
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