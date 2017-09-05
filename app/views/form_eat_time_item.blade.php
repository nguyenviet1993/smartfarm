@extends('layouts.main_layout')
@section('head')
    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
@endsection
@section('title')
    Danh mục giờ cho ăn
@endsection
@section('head')
    <style>
        .paging_link ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #333;
        }

        .paging_link li {
            float: left;
        }

        .paging_link li a {
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }

        /* Change the link color to #111 (black) on hover */
        .paging_link li a:hover {
            background-color: #111;
        }
    </style>
@endsection
@section('main_content')

    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title"><span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Danh mục giờ cho ăn</h5>
                    </div>
                    <div class="widget-content nopadding">
                        @if(Session::has('success_eat_time_item'))
                            <div class="alert alert-success">{{Session::get('success_eat_time_item')}}</div>
                        @endif
                        <form action="/add-eat-time-item-action" method="post" class="form-horizontal">
                            <input type="text" id="category_id" name="category_id" style="visibility: hidden"/>
                            <div class="control-group">
                                <label class="control-label">Giờ: </label>
                                <div class="controls">
                                    <select name="value" id="value">
                                        @for($k=1;$k<=24;$k++)
                                            <option value="{{$k}}">{{$k}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Phút:</label>
                                <div class="controls">
                                    <select name="value1" id="value1">
                                        @for($h=0;$h<=55;$h++)
                                            <option value="{{$h}}">{{$h}}</option>
                                            <?php $h += 4;?>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Vị trí: </label>
                                <div class="controls">
                                    <input type="text" class="span8" placeholder="Vị trí" name="order" id="order"
                                           value="{{$order_max}}"/>
                                </div>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-success">Lưu</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title"><span class="icon"> <i class="icon-file"></i> </span>
                        <h5>Danh mục giờ cho ăn</h5>
                    </div>
                    @if(Session::has('success_del_eat_time_item'))
                        <div class="alert alert-success">{{Session::get('success_del_eat_time_item')}}</div>
                    @endif
                    <div class="widget-content nopadding">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Tên thuốc</th>
                                <th>Vị trí</th>
                                <th>Sửa</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($smart_time as $item)
                                <tr>
                                    <td><a href="#"
                                           onclick="updateCatalog('<?= $item['category_id']?>', '<?= $item['value']?>','<?= $item['value1']?>', '<?= $item['order']?>')">{{$item['category_name']}}</a>
                                    </td>
                                    <td style="text-align: right">{{$item['order']}}</td>
                                    <td style="text-align: center">
                                        <a href="#"
                                           onclick="updateCatalog('<?= $item['category_id']?>', '<?= $item['value']?>','<?= $item['value1']?>', '<?= $item['order']?>')"><span
                                                    class="icon-edit"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="js/date-time-picker/jquery.js"></script>
    <script src="js/date-time-picker/jquery.datetimepicker.full.min.js"></script>
    <script>
        function updateCatalog(cat_id, value, value1, order) {
            $('#value').val(value);
            $('#value1').val(value1);
            $('#category_id').val(cat_id);
            $('#order').val(order);
            $("#value selected").val(value);
            $('#value option[value=' + value + ']').attr('selected', 'selected');

            $("#value1 selected").val(value1);
            $('#value1 option[value=' + value1 + ']').attr('selected', 'selected');
        }

        $.datetimepicker.setLocale('vi');
        $('#datetimepicker').datetimepicker({
            timepicker: false,
            format: 'd-m-Y'
        });
    </script>
@endsection
