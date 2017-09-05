@extends('layouts.main_layout')
@section('title')
    Nhập thông tin trong ngày
@endsection
@section('main_content')

    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title"><span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Thông tin trong ngày <span style="color: #0e90d2">{{$lake['lake_name']}}</span></h5>
                    </div>
                    <div class="widget-box">
                        <div class="widget-title">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#tab1">Cho ăn</a></li>
                                <li><a data-toggle="tab" href="#tab2">Thuốc</a></li>
                            </ul>
                        </div>
                        <div class="widget-content tab-content">
                            <div id="tab1" class="tab-pane active">
                                <div class="widget-content nopadding">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            @foreach($categories as $category)
                                                <th>{{$category['category_name']}}</th>
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="odd gradeX">
                                            <td>Ao 1</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>3</td>
                                            <td>4</td>
                                            <td>5</td>
                                            <td>6</td>
                                            <td>7</td>
                                            <td>8</td>
                                            <td>2</td>
                                            <td>3</td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td>Ao 1</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>3</td>
                                            <td>4</td>
                                            <td>5</td>
                                            <td>6</td>
                                            <td>7</td>
                                            <td>8</td>
                                            <td>2</td>
                                            <td>3</td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td>Ao 1</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>3</td>
                                            <td>4</td>
                                            <td>5</td>
                                            <td>6</td>
                                            <td>7</td>
                                            <td>8</td>
                                            <td>2</td>
                                            <td>3</td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td>Ao 1</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>3</td>
                                            <td>4</td>
                                            <td>5</td>
                                            <td>6</td>
                                            <td>7</td>
                                            <td>8</td>
                                            <td>2</td>
                                            <td>3</td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td>Ao 1</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>3</td>
                                            <td>4</td>
                                            <td>5</td>
                                            <td>6</td>
                                            <td>7</td>
                                            <td>8</td>
                                            <td>2</td>
                                            <td>3</td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td>Ao 1</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>3</td>
                                            <td>4</td>
                                            <td>5</td>
                                            <td>6</td>
                                            <td>7</td>
                                            <td>8</td>
                                            <td>2</td>
                                            <td>3</td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td>Ao 1</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>3</td>
                                            <td>4</td>
                                            <td>5</td>
                                            <td>6</td>
                                            <td>7</td>
                                            <td>8</td>
                                            <td>2</td>
                                            <td>3</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success">Lưu</button>
                                </div>
                            </div>
                            <div id="tab2" class="tab-pane">
                                <div class="widget-content nopadding">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            @foreach($categories as $category)
                                                <th>{{$category['category_name']}}</th>
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr class="odd gradeX">
                                            <td>Ao 1</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>3</td>
                                            <td>4</td>
                                            <td>5</td>
                                            <td>6</td>
                                            <td>7</td>
                                            <td>8</td>
                                            <td>2</td>
                                            <td>3</td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td>Ao 1</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>3</td>
                                            <td>4</td>
                                            <td>5</td>
                                            <td>6</td>
                                            <td>7</td>
                                            <td>8</td>
                                            <td>2</td>
                                            <td>3</td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td>Ao 1</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>3</td>
                                            <td>4</td>
                                            <td>5</td>
                                            <td>6</td>
                                            <td>7</td>
                                            <td>8</td>
                                            <td>2</td>
                                            <td>3</td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td>Ao 1</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>3</td>
                                            <td>4</td>
                                            <td>5</td>
                                            <td>6</td>
                                            <td>7</td>
                                            <td>8</td>
                                            <td>2</td>
                                            <td>3</td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td>Ao 1</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>3</td>
                                            <td>4</td>
                                            <td>5</td>
                                            <td>6</td>
                                            <td>7</td>
                                            <td>8</td>
                                            <td>2</td>
                                            <td>3</td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td>Ao 1</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>3</td>
                                            <td>4</td>
                                            <td>5</td>
                                            <td>6</td>
                                            <td>7</td>
                                            <td>8</td>
                                            <td>2</td>
                                            <td>3</td>
                                        </tr>
                                        <tr class="odd gradeX">
                                            <td>Ao 1</td>
                                            <td>1</td>
                                            <td>2</td>
                                            <td>3</td>
                                            <td>4</td>
                                            <td>5</td>
                                            <td>6</td>
                                            <td>7</td>
                                            <td>8</td>
                                            <td>2</td>
                                            <td>3</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-success">Lưu</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection