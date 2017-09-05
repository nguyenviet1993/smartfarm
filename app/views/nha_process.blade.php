@extends('layouts.layout_not_jquery')
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
    <link type="text/css" rel="stylesheet" href="css/ui.notify.css" />
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
                <div class="widget-box">
                    <div class="widget-title"><span class="icon"> <i class="icon-th"></i> </span>
                        <h5>Thông tin Nhá hôm nay</h5>
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
                                                            <td class="fixed-row">{{@$new_nha[$key][$j]['time']}}</td>
                                                            <td style="border-left: none"></td>
                                                            <td>
                                                                <select style="width: 60px;"
                                                                        id='HOUR_{{$key}}{{$new_nha[$key][$j]['time']}}'
                                                                        name="hour"
                                                                        onchange="updateValue('<?=$key?>','<?=$new_nha[$key][$j]['time']?>');">
                                                                    @for($k=1;$k<=24;$k++)
                                                                        @if($new_nha[$key][$j]['hour'] == $k)
                                                                            <option value="{{$k}}"
                                                                                    selected>{{$k}}</option>
                                                                        @else
                                                                            <option value="{{$k}}">{{$k}}</option>
                                                                        @endif
                                                                    @endfor
                                                                </select>
                                                                <select style="width: 60px;"
                                                                        id="MINUTE_{{$key}}{{$new_nha[$key][$j]['time']}}"
                                                                        name="minute"
                                                                        onchange="updateValue('<?=$key?>','<?=$new_nha[$key][$j]['time']?>');">
                                                                    @for($h=0;$h<=50;$h++)
                                                                        @if($new_nha[$key][$j]['minute'] == $h)
                                                                            <option value="{{$h}}"
                                                                                    selected>{{$h}}</option>
                                                                        @else
                                                                            <option value="{{$h}}">{{$h}}</option>
                                                                        @endif
                                                                        <?php $h += 9;?>
                                                                    @endfor
                                                                </select>
                                                            </td>
                                                            <td class="form-group">
                                                                {{\Illuminate\Support\Facades\Form::open(array('url'=>'/upload-image','files'=>true, 'method'=>'post'))}}
                                                                @if(@$new_nha[$key][$j]['image_url'] != "")
                                                                    <div id="preview_{{$key}}{{$new_nha[$key][$j]['time']}}">
                                                                        <img src="{{@$new_nha[$key][$j]['image_url']}}"
                                                                             style="width: 180px"/>
                                                                    </div>
                                                                @endif
                                                                <input type="file" class="image_upload"
                                                                       id="uploadimage_{{$key}}{{$new_nha[$key][$j]['time']}}"
                                                                       multiple
                                                                       data-min-file-count="1" name="file"
                                                                       onchange="updateImage('<?= $key?>', '<?= $new_nha[$key][$j]['time']?>')"/>

                                                                {{\Illuminate\Support\Facades\Form::close();}}
                                                            </td>
                                                            <td>

                                                                <select style="width: auto;" name="duration"
                                                                        id="DURATION_{{$key}}{{$new_nha[$key][$j]['time']}}"
                                                                        onchange="updateValue('<?=$key?>','<?=$new_nha[$key][$j]['time']?>');">
                                                                    @if($new_nha[$key][$j]['duration'] == '1.5')
                                                                        <option value="1.5" selected>1,5 giờ</option>
                                                                        <option value="2">2 giờ</option>
                                                                        <option value="2.5">2,5 giờ</option>
                                                                    @endif
                                                                    @if($new_nha[$key][$j]['duration'] == '2')
                                                                        <option value="1.5">1,5 giờ</option>
                                                                        <option value="2" selected>2 giờ</option>
                                                                        <option value="2.5">2,5 giờ</option>
                                                                    @endif
                                                                    @if($new_nha[$key][$j]['duration'] == '2.5')
                                                                        <option value="1.5">1,5 giờ</option>
                                                                        <option value="2">2 giờ</option>
                                                                        <option value="2.5" selected>2,5 giờ</option>
                                                                    @endif
                                                                </select>
                                                            </td>
                                                            <td style="min-width: 200px">
                                                                <textarea class="span11" name="result" rows="2"
                                                                          id="RESULT_{{$key}}{{$new_nha[$key][$j]['time']}}">{{@$new_nha[$key][$j]['result']}}</textarea><br/>
                                                                <a onclick="updateValue('<?=$key?>','<?=$new_nha[$key][$j]['time']?>');"
                                                                   class="btn btn-success">Lưu</a>
                                                            </td>
                                                        </tr>
                                                    @endfor
                                                    <?php $time = !empty($new_nha[$key]) ? (count($new_nha[$key]) + 1) : 1;?>
                                                    <tr class="odd gradeX" id='col_repeat_{{$key}}{{$time}}'>
                                                        <td class="fixed-row">{{$time}}</td>
                                                        <td style="border-left: none"></td>
                                                        <td>
                                                            <select style="width: 60px;" id='HOUR_{{$key}}{{$time}}'
                                                                    name="hour">
                                                                @for($k=1;$k<=24;$k++)
                                                                    <option value="{{$k}}">{{$k}}</option>
                                                                @endfor
                                                            </select>
                                                            <select style="width: 60px;"
                                                                    id="MINUTE_{{$key}}{{$time}}"
                                                                    name="minute">
                                                                @for($h=0;$h<=50;$h++)
                                                                    <option value="{{$h}}">{{$h}}</option>
                                                                    <?php $h += 9;?>
                                                                @endfor
                                                            </select>
                                                        </td>
                                                        <td class="form-group">
                                                            {{\Illuminate\Support\Facades\Form::open(array('url'=>'/upload-image','files'=>true, 'method'=>'post'))}}
                                                            <input type="file" class="image_upload"
                                                                   id="uploadimage_{{$key}}{{$time}}" multiple
                                                                   data-min-file-count="1" name="file"
                                                                   onchange="uploadImage('<?= $key?>', '<?= $time?>')"/>

                                                            {{\Illuminate\Support\Facades\Form::close();}}
                                                        </td>
                                                        <td>

                                                            <select style="width: auto;" name="duration"
                                                                    id="DURATION_{{$key}}{{$time}}">
                                                                <option value="1.5">1,5 giờ</option>
                                                                <option value="2">2 giờ</option>
                                                                <option value="2.5">2,5 giờ</option>
                                                            </select>
                                                        </td>
                                                        <td style="min-width: 200px">
                                                                <textarea class="span11" name="result" rows="2"
                                                                          id="RESULT_{{$key}}{{$time}}"></textarea><br/>
                                                            <a onclick="updateValue('<?=$key?>','<?=$time?>');"
                                                               class="btn btn-success">Lưu</a>
                                                        </td>
                                                    </tr>
                                                    <tr id="table_row_{{$key}}">

                                                    </tr>

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

    {{--<script src="js/jquery/jquery.js" type="text/javascript"></script>--}}
    {{--<script src="js/jquery/jquery-ui.js" type="text/javascript"></script>--}}
    {{--<script src="js/jquery.notify.js" type="text/javascript"></script>--}}

    {{--<script type="text/javascript">--}}
        {{--function create( template, vars, opts ){--}}
            {{--return $container.notify("create", template, vars, opts);--}}
        {{--}--}}

        {{--$(function(){--}}
            {{--$container = $("#container").notify();--}}

        {{--});--}}

    {{--</script>--}}
    <script src="js/jquery.min.js"></script>
    {{--<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>--}}
    <script src="bootstrap-fileinput/js/plugins/canvas-to-blob.min.js" type="text/javascript"></script>
    <script src="bootstrap-fileinput/js/fileinput.min.js"></script>
    <script>
        function uploadImage(lake_id, time_id) {

            var hour_val = $('#HOUR_' + lake_id + time_id).val();
            var str_hour = $('#HOUR_' + lake_id + time_id).html()
            $('#HOUR_' + lake_id + time_id).attr('value', hour_val);
            $('#HOUR_' + lake_id + time_id).attr('onchange', 'updateValue(\'' + time_id + '\',\'' + lake_id + '\')');


            var minute_val = $('#MINUTE_' + lake_id + time_id).val();
            var str_minute = $('#MINUTE_' + lake_id + time_id).html()
            $('#MINUTE_' + lake_id + time_id).attr('value', minute_val);
            $('#MINUTE_' + lake_id + time_id).attr('onchange', 'updateValue(\'' + time_id + '\',\'' + lake_id + '\')');

            var duration_val = $('#DURATION_' + lake_id + time_id).val();
            var str_duration = $('#DURATION_' + lake_id + time_id).html()
            $('#DURATION_' + lake_id + time_id).attr('value', minute_val);
            $('#DURATION_' + lake_id + time_id).attr('onchange', 'updateValue(\'' + time_id + '\',\'' + lake_id + '\')');

            var result_val = $('#RESULT_' + lake_id + time_id).val();
            $('#RESULT_' + lake_id + time_id).attr('value', minute_val);
            $('#preview_' + lake_id + time_id).html('');

            var file_data = $('#uploadimage_' + lake_id + time_id).prop('files')[0];
            $('#uploadimage_' + lake_id + time_id).removeAttr('onchange');
            $('#uploadimage_' + lake_id + time_id).attr('onchange', 'updateImage(\'' + time_id + '\',\'' + lake_id + '\')');

            var form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append('hour', hour_val);
            form_data.append('minute', minute_val);
            form_data.append('duration', duration_val);
            form_data.append('result', result_val);
            form_data.append('lake_id', lake_id);
            form_data.append('time', time_id);

            location.reload(true);
            $.ajax({
                url: "/upload-image", // Url to which the request is send
                type: "POST",             // Type of request to be send, called as method
                data: form_data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData: false,        // To send DOMDocument or non processed data file it is set to false
                success: function (data)   // A function to be called if request succeeds
                {
//                    create("default", { title:'Thông báo', text:'Thành công!'});

                }
            });

        }

        function updateValue(lake_id, time_id) {

            var hour_val = $('#HOUR_' + lake_id + time_id).val();
            var minute_val = $('#MINUTE_' + lake_id + time_id).val();
            var duration_val = $('#DURATION_' + lake_id + time_id).val();
            var result_val = $('#RESULT_' + lake_id + time_id).val();

            var agrs = {
                url: "/update-nha-process",
                type: "get",
                dateType: "text",
                data: {
                    hour: hour_val,
                    minute: minute_val,
                    duration: duration_val,
                    lake_id: lake_id,
                    result: result_val,
                    time: time_id,
                },
                success: function (result) {
//                    create("default", { title:'Thông báo', text:'Thành công!'});
                }
            };

            $.ajax(agrs);
        }


        function updateImage(lake_id, time_id) {

            $('#preview_' + lake_id + time_id).html('');
            var file_data = $('#uploadimage_' + lake_id + time_id).prop('files')[0];
            var form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append('lake_id', lake_id);
            form_data.append('time', time_id);

            $.ajax({
                url: "/update-nha-image", // Url to which the request is send
                type: "POST",             // Type of request to be send, called as method
                data: form_data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData: false,        // To send DOMDocument or non processed data file it is set to false
                success: function (data)   // A function to be called if request succeeds
                {
//                    create("default", { title:'Thông báo', text:'Thành công!'});

                }
            });
        }

        $(".image_upload").fileinput({
            overwriteInitial: true,
            maxFileSize: 4500,
            showClose: true,
            showCaption: false,
            browseLabel: '',
            removeLabel: 'Xóa',
            removeIcon: '<i class="icon-remove-sign"></i>',
            removeTitle: 'Xóa',
            elErrorContainer: '#kv-avatar-errors',
            msgErrorClass: 'alert alert-block alert-danger',
            layoutTemplates: {main2: '{preview} {browse}'},
            allowedFileExtensions: ["jpg", "png", "gif"],
            browseClass: 'btn'
        });


    </script>

@endsection