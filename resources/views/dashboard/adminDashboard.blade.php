@extends('dashboard.adminlayout.admin')


@section('content')
    <section class="content-header">
        <h1>
            {{__('site.dashboard')}}

        </h1>
        <ol class="breadcrumb">

            <li class="active">{{__('site.dashboard')}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{$categories_count}}</h3>

                        <p>{{__('site.categories')}}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{route('dashboard.categories.index')}}" class="small-box-footer"><i class="fa fa-arrow-circle-left"></i> {{__('site.show')}} </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{$products_count}}<sup style="font-size: 20px"></sup></h3>

                        <p> {{__('site.products')}}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{route('dashboard.products.index')}}" class="small-box-footer"><i class="fa fa-arrow-circle-left"></i> {{__('site.show')}} </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{$clients_count}}</h3>

                        <p>{{__('site.clients')}}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{route('dashboard.clients.index')}}" class="small-box-footer"><i class="fa fa-arrow-circle-left"></i> {{__('site.show')}} </a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{$users_count}}</h3>

                        <p>{{__('site.users')}}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{route('dashboard.users.index')}}" class="small-box-footer"><i class="fa fa-arrow-circle-left"></i> {{__('site.show')}} </a>          </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <div class="box box-solid bg-teal-gradient">
            <div class="box-header">

                <h3 class="box-title"> </h3>
            </div>
            <div class="box-body border-radius-none">
                <div class="chart" id="line-chart" style="height: 250px;"></div>
            </div>
            <!-- /.box-body -->
        </div>
    </section>
@endsection
@push('script')
    <script>
        $(document).ready(function () {
            var line = new Morris.Line({
                element          : 'line-chart',
                resize           : true,
                data             : [
                        @foreach($sales_data as $data){
                        ym:"{{$data->year}}-{{$data->month}}",sum:"{{$data->sum}}"
                    },
                    @endforeach

                ],
                xkey             : 'ym',
                ykeys            : ['sum'],
                labels           : ['{{__('site.total')}}'],
                lineColors       : ['#efefef'],
                lineWidth        : 2,
                hideHover        : 'auto',
                gridTextColor    : '#fff',
                gridStrokeWidth  : 0.4,
                pointSize        : 4,
                pointStrokeColors: ['#efefef'],
                gridLineColor    : '#efefef',
                gridTextFamily   : 'Open Sans',
                gridTextSize     : 10
            });

        });

    </script>
@endpush

