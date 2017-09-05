@extends('layouts.main_layout')
@section('title')
    Chỉ số vật nuôi
@endsection
@section('main_content')
    <?php setlocale(LC_MONETARY, "en_US");?>
    <div class="container-fluid">
        <div class="quick-actions_homepage">
            <ul class="quick-actions">
                @foreach($lakes as $key=>$value)
                    <?php
                    if (!empty($value['start_date'])) {
                        $old_date1 = new DateTime(date('d-m-Y', strtotime($value['start_date'])));
                        $new_date1 = new DateTime(date('d-m-Y', time()));
                        $interval1 = date_diff($new_date1, $old_date1);
                        $format1 = '- ' . $interval1->format('%a');
                    } else {
                        $format1 = "";
                    }

                    ?>
                    <li {{($value['status']==1?'class=bg_lo':'')}}{{($value['status']==2?'class=bg_lh':'')}}{{($value['status']==3?'class=bg_ly':'')}}{{($value['status']==4?'class=bg_lr':'');}}{{($value['status']==5?'class=bg_lb':'');}}>
                        <a href="/update-shrimp-index?id={{$value['lake_id']}}"> <i class="icon-dashboard"></i>
                            <span class="label label-success">{{number_format($value['amount_brood'],0)}}
                                /{{number_format($value['acreage'],0)}}</span>
                            <h4>{{$value['lake_name']}} ({{$value['seed_source']}} {{$format1}})</h4>
                            @if($value['status'] == 3 || $value['status'] == 4 || $value['status'] == 5)
                                @if(@$shrimp_indexs[$value['lake_id']]['amount'] != '')
                                    <h5 style="color: #ffffff">{{$shrimp_indexs[$value['lake_id']]['amount']}}
                                        con/kg</h5>
                                @else
                                    <h5 style="color: #ffffff">&nbsp;</h5>
                                @endif
                                @if(@$shrimp_indexs[$value['lake_id']]['check_date'] != '')
                                    <h6 style="color: #ffffff">{{$shrimp_indexs[$value['lake_id']]['check_date']}}</h6>
                                @else
                                    <h6 style="color: #ffffff">&nbsp;</h6>
                                @endif
                            @else
                                <h5 style="color: #ffffff">&nbsp;</h5>
                                <h6 style="color: #ffffff">&nbsp;</h6>
                            @endif
                            @if($value['status']==1)
                                <span class="badge badge-inverse">Đang xử lý ao</span>
                            @endif
                            @if($value['status']==2)
                                <span class="badge badge-inverse">Đã xả bỏ</span>
                            @endif
                            @if($value['status']==3)
                                <span class="badge badge-inverse">Đang hạ nước</span>
                            @endif
                            @if($value['status']==4)
                                <span class="badge badge-inverse">Đang đánh thuốc</span>
                            @endif
                            @if($value['status']==5)
                                <span class="badge badge-inverse">Đang nuôi</span>
                            @endif

                        </a>
                    </li>
                @endforeach
                <li class="bg_lg"><a href="form-add-lake"> <i class="icon-plus-sign"></i> <span
                                class="label label-warning"></span> Thêm mới ao nuôi </a>
                </li>
            </ul>
        </div>
    </div>
@endsection