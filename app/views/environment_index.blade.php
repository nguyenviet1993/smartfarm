@extends('layouts.layout_not_jquery')
@section('title')
    Nhập thông tin trong ngày
@endsection
@section('head')
    <style>
        th, td {
            white-space: nowrap;
        }
    </style>
    <link type="text/css" rel="stylesheet" href="css/ui.notify.css" />
@endsection
@section('main_content')
    <style>
        .fixed-colum{
            width: 70px !important;
            position: absolute;
            margin-left: -15px;
            background: #EFEFEF !important;
            border-right: solid 1px #DDDDDD;
        }
        .fixed-row{
            width: 62px;
            position: absolute;
            margin-left: -15px;
            height: 40px !important;
            border-right: solid 1px #DDDDDD;
            background: #F9F9F9 !important;
        }
    </style>

    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"><span class="icon"> <i class="icon-th"></i> </span>
                        <h5>Thông tin hôm nay</h5>
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
                                                        <th class="fixed-colum">Lần đo</th>

                                                        @foreach($times as $time)
                                                            <th>{{$time['category_name']}}</th>
                                                        @endforeach
                                                    </tr>
                                                    </thead>
                                                    <tbody id='table_repeat_{{$key}}'>
                                                    @foreach($environments as $environment)
                                                        <tr class="odd gradeX">
                                                            <td class="fixed-row">{{$environment['category_name']}}</td>

                                                            @foreach($times as $time)
                                                                <td >
                                                                    <select style="width: 60px; visibility: hidden;">
                                                                            <option></option>
                                                                    </select>
                                                                    <select style="width: 60px;"
                                                                            id="HOUR_{{$key}}_{{$environment['category_id']}}_{{$time['category_id']}}"
                                                                            onchange="changeValueItem('<?= $key ?>', '<?= $environment['category_id']?>','<?= $time['category_id']?>')">
                                                                        @for($k=1;$k<=24;$k++)
                                                                            @if(@$index[$key.$environment['category_id'].$time['category_id']]['hour'] == $k)
                                                                                <option value="{{$k}}"
                                                                                        selected>{{$k}}</option>
                                                                            @else
                                                                                <option value="{{$k}}">{{$k}}</option>
                                                                            @endif
                                                                        @endfor
                                                                    </select>
                                                                    <select style="width: 60px;"
                                                                            onchange="changeValueItem('<?= $key ?>', '<?= $environment['category_id']?>','<?= $time['category_id']?>')"
                                                                            id="MINUTE_{{$key}}_{{$environment['category_id']}}_{{$time['category_id']}}">
                                                                        @for($h=0;$h<=50;$h++)
                                                                            @if(@$index[$key.$environment['category_id'].$time['category_id']]['minute'] == $h)
                                                                                <option value="{{$h}}" selected>{{$h}}</option>
                                                                            @else
                                                                                <option value="{{$h}}">{{$h}}</option>
                                                                            @endif
                                                                            <?php $h += 9;?>
                                                                        @endfor
                                                                    </select>
                                                                    <input type="number" class="input-val"
                                                                           value="{{@$index[$key.$environment['category_id'].$time['category_id']]['val']}}"
                                                                           onchange="changeValueItem('<?= $key ?>', '<?= $environment['category_id']?>','<?= $time['category_id']?>')"
                                                                           id="VAL_{{$key}}_{{$environment['category_id']}}_{{$time['category_id']}}" />
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
    <div id="content">
        <!--- container to hold notifications, and default templates --->
        <div id="container" style="display:none">
            <div id="default">
                <h1>#{title}</h1>
                <p>#{text}</p>
            </div>
        </div>
    </div>
    <script>
        function changeValueItem(lake_id, type_id, time_id) {
            //get value by id
            var hour = $('#HOUR_' + lake_id + '_' + type_id + '_' + time_id).val();
            var minute = $('#MINUTE_' + lake_id + '_' + type_id + '_' + time_id).val();
            var val = $('#VAL_' + lake_id + '_' + type_id + '_' + time_id).val();
            var agrs = {
                url: "/input-environment-index",
                type: "get",
                dateType: "text",
                data: {
                    time_id: time_id,
                    type_id: type_id,
                    hour: hour,
                    minute: minute,
                    val: val,
                    lake_id: lake_id,
                },
                success: function (result) {
//                    create("default", { title:'Thông báo', text:'Thành công!'});
                }
            };

            $.ajax(agrs);
        }
    </script>

    <script src="js/jquery/jquery.js" type="text/javascript"></script>
    <script src="js/jquery/jquery-ui.js" type="text/javascript"></script>
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