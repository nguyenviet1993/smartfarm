@extends('layouts.main_layout')
@section('title')
    Quyết toán
@endsection
@section('main_content')

    <div class="container-fluid">
        <div class="row-fluid">
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title"><span class="icon"> <i class="icon-align-justify"></i> </span>
                        <h5>Quyết toán ngày <span style="color: red"><?= date('d-m-Y')?></span></h5>
                    </div>
                    <div class="widget-content nopadding">
                        @if(Session::has('error_statement'))
                            <div class="alert alert-error">{{Session::get('error_statement')}}</div>
                        @endif
                        @if(Session::has('success_statement'))
                            <div class="alert alert-success">{{Session::get('success_statement')}}</div>
                        @endif
                        <form action="/settlement-action" method="post" class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label">Tổng chi phí hàng tháng :</label>
                                <label class="control-label"
                                       style="text-align: left; margin-left: 20px; color: red">{{number_format($fee_sum,0)}}
                                    vnđ</label>
                                <input name="fees" value="{{$fee_sum}}" style="visibility: hidden"/>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Tổng chi phí xây dựng cơ bản :</label>
                                <label class="control-label"
                                       style="text-align: left; margin-left: 20px; color: red">{{number_format($inventory_sum,0)}}
                                    vnđ</label>
                                <input name="inventories" value="{{$inventory_sum}}" style="visibility: hidden"/>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Tổng tiền thu hoạch: </label>
                                <label class="control-label"
                                       style="text-align: left; margin-left: 20px; color: red">{{number_format($harvesting_sum,0)}}
                                    vnđ</label>
                                <input name="harvesting" value="{{$harvesting_sum}}" style="visibility: hidden"/>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Số dư kì trước</label>
                                <label class="control-label"
                                       style="text-align: left; margin-left: 20px; color: red">{{number_format($reconciliation,0)}} vnđ</label>
                                <input name="reconciliation" value="{{$reconciliation}}" style="visibility: hidden"/>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Lãi suất</label>
                                <label class="control-label"
                                       style="text-align: left; margin-left: 20px; color: green">{{number_format($interest,0)}}
                                    vnđ</label>
                                <input name="interest_rate" value="{{$interest}}" style="visibility: hidden"/>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Ghi chú</label>
                                <textarea class="span7" name="note" rows="5"
                                          style="text-align: left; margin-left: 20px; color: green"></textarea>
                            </div>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-success" onclick="return confirm('Bạn có muốn quyết toán không?')">Quyết toán</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('select2js')
    <script src="js/select2.min.js"></script>
@endsection