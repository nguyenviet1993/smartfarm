@extends('layouts.main_layout')
@section('title')
    Danh sách người dùng
@endsection
@section('main_content')
    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"><span class="icon"> <i class="icon-th"></i> </span>
                        <h5>Thông tin người dùng</h5>
                    </div>

                    <div class="widget-content tab-content">
                        <div id="tab1" class="tab-pane active">
                            <div class="widget-content nopadding">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Tên đăng nhập</th>
                                        <th>Tên đầy đủ</th>
                                        <th>Số điện thoại</th>
                                        <th>Email</th>
                                        <th>Quyền</th>
                                        <th>Sửa</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $i = 0?>
                                    @foreach($users as $user)
                                        <tr class="odd gradeX">
                                            <td>{{$i}}</td>
                                            <td>{{$user['username']}}</td>
                                            <td>{{$user['full_name']}}</td>
                                            <td>{{$user['phone_number']}}</td>
                                            <td>{{$user['email']}}</td>
                                            <td>{{$user['role_name']}}</td>
                                            <td><a class="tip" href="/edit-user?username={{$user['username']}}"
                                                   title="Sửa"><i
                                                            class="icon-pencil"></i></a> <a class="tip" href="#"
                                                                                            title="Xóa"><i
                                                            class="icon-remove"></i></a></td>
                                        </tr>
                                        <?php $i++?>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <a class="btn btn-success" href="/add-user" style="margin: 10px 0px 10px 10px">Thêm</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection