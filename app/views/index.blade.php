@extends('layouts.main_layout')
@section('title')
    Thống kê
@endsection
@section('main_content')
    <div class="container-fluid">
        <div class="quick-actions_homepage">
            <ul class="quick-actions">
                @foreach($lakes as $key=>$value)
                    <li class="bg_lb" style="padding-bottom: 10px"><a href="/"> <i class="icon-bar-chart"></i> <span
                                    class="label label-warning"></span> {{$key}} </a>
                        @foreach($value as $item)
                            <span style="color: #ffffff; padding: 0px 10px">Ăn: {{$item['food_type']}}
                                - {{$item['food_val']}} KG</span><br/>
                            <span style="color: #ffffff; padding: 0px 10px;">
                                @if($item['drug_val_1'] != 0 || $item['drug_val_2'] != 0 || $item['drug_val_3'] != 0)
                                    Thuốc:
                                    @if($item['drug_val_1'] != 0)
                                        {{$item['drug_1']}} - {{$item['drug_val_1']}}
                                    @endif
                                    @if($item['drug_val_2'] != 0)
                                        | {{$item['drug_2']}} - {{$item['drug_val_2']}}
                                    @endif
                                    @if($item['drug_val_3'] != 0)
                                        | {{$item['drug_3']}} - {{$item['drug_val_3']}}
                                    @endif
                                @endif
                            </span><br/>
                        @endforeach

                    </li>
                @endforeach
                <li class="bg_lg"><a href="form-add-lake"> <i class="icon-plus-sign"></i> <span
                                class="label label-warning"></span> Thêm mới ao nuôi </a>
                </li>
            </ul>
        </div>
    </div>

@endsection