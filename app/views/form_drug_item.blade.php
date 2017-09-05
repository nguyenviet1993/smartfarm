@extends('layouts.main_layout')
@section('head')
    <link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.css"/>
@endsection
@section('title')
    Danh mục thuốc
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
                        <h5>Danh mục thuốc</h5>
                    </div>
                    <div class="widget-content nopadding">
                        @if(Session::has('success_drug_item'))
                            <div class="alert alert-success">{{Session::get('success_drug_item')}}</div>
                        @endif
                        <form action="/add-drug-item-action" method="post" class="form-horizontal">
                            <input type="text" id="category_id" name="category_id" style="visibility: hidden" />
                            <div class="control-group">
                                <label class="control-label">Tên thuốc (*): </label>
                                <div class="controls">
                                    <input type="text" class="span11" placeholder="Nhập tên thuốc" name="category_name" id="category_name"
                                           required/>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Loại:</label>
                                <div class="controls">
                                    <select name="type" id="type">
                                        <option value="1">Kháng sinh</option>
                                        <option value="2">Thuốc bổ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Vị trí: </label>
                                <div class="controls">
                                    <input type="text" class="span8" placeholder="Vị trí" name="order" id="order" value="{{$order_max}}" />
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
                        <h5>Danh mục thuốc</h5>
                    </div>
                    @if(Session::has('success_del_drug_item'))
                        <div class="alert alert-success">{{Session::get('success_del_drug_item')}}</div>
                    @endif
                    <div class="widget-content nopadding">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Tên thuốc</th>
                                <th>Loại</th>
                                <th>Vị trí</th>
                                <th>Sửa</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($drugs as $drug)
                                <tr>
                                    <td><a href="#" onclick="updateCatalog('<?= $drug['category_name']?>','<?= $drug['category_id']?>', '<?= $drug['type']?>', '<?= $drug['order']?>')">{{$drug['category_name']}}</a></td>
                                    <td style="">{{$drug['type']==1?'Kháng sinh':'Thuốc bổ'}}</td>
                                    <td style="text-align: right">{{$drug['order']}}</td>
                                    <td style="text-align: center">
                                        <a href="#" onclick="updateCatalog('<?= $drug['category_name']?>','<?= $drug['category_id']?>', '<?= $drug['type']?>', '<?= $drug['order']?>')"><span class="icon-edit"></span></a>
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
        function updateCatalog(catalog_name, cat_id, type, order) {
            $('#category_name').val(catalog_name);
            $('#category_id').val(cat_id);
            $('#order').val(order);
            $("#type selected").val(type);
            $('#type option[value=' + type + ']').attr('selected', 'selected');
        }

        $.datetimepicker.setLocale('vi');
        $('#datetimepicker').datetimepicker({
            timepicker: false,
            format: 'd-m-Y'
        });
    </script>
@endsection
