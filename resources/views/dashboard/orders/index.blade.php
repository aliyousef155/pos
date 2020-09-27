@extends('dashboard.adminlayout.admin')


@section('content')
    <section class="content-header">
        @if(Session::has('success'))
            <div class="alert alert-success fade-message" style="width: 60vh">
                <p >{{session('success')}}</p>
            </div>
        @endif
<h1>{{__('site.all_orders')}}</h1>
        <ol class="breadcrumb">

            <li class=""><a href="{{route('dashboard.admin')}}">{{__('site.dashboard')}}</a></li>
            <li class="active">{{__('site.orders')}}</li>
        </ol>
    </section>

    <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-md-8">
                     <div class="box box-primary">
                         <div class="box-header">
                             <h3 class="box-title" style="margin-bottom: 10px">  {{__('site.orders')}}</h3>
                             <form action="{{route('dashboard.orders.index')}}" method="get">
                                 <div class="row">
                                     <div class="col-md-8">
                                         <input type="text" name="search" class="form-control">
                                     </div>
                                     <div class="col-md-4">
                                         <button type="submit" class="btn btn-primary"><i class="fa fa-search">{{__('site.search')}}</i></button>
                                     </div>
                                 </div>
{{--                                 end of row--}}
                             </form>
{{--                             end of form--}}
                         </div>
{{--                         end of box header--}}
                         @if($orders->count() > 0)
                             <div class="box-body">
                                 <table class="table table-hover">
                                     <tr>
                                         <th>{{__('site.client_name')}}</th>
                                         <th>{{__('site.price')}}</th>
{{--                                         <th>{{__('site.status')}}</th>--}}
                                         <th>{{__('site.created_at')}}</th>
                                         <th>{{__('site.action')}}</th>
                                     </tr>
                                     @foreach($orders as $order)
                                         <tr>
                                             <td>{{$order->client->name}}</td>
                                             <td>{{$order->total_price}}</td>
                                             <td>{{$order->created_at->toFormattedDateString()}}</td>
                                             <td>
                                                 <button class="btn btn-primary btn-sm order-product" data-url="{{route('dashboard.orders.products',$order->id)}}" data-method="get">
                                                     <i class="fa fa-list"></i>
                                                     {{__('site.show')}}
                                                 </button>
                                                 @if(auth()->user()->hasPermission('orders_update'))
                                                     <a href="{{route('dashboard.clients.orders.edit',['client'=>$order->client->id,'order'=>$order->id])}}" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i> {{__('site.edit')}}</a>
                                                 @else
                                                     <a href="" class="btn btn-info btn-sm" disabled=""><i class="fa fa-edit"></i> {{__('site.edit')}}</a>
                                                 @endif
                                                 @if(auth()->user()->hasPermission('orders_delete'))
                                                     <form action="{{route('dashboard.orders.destroy',$order->id)}}" method="post" style="display: inline-block">
                                                         {{csrf_field()}}
                                                         {{method_field('delete')}}
                                                         <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> {{__(('site.delete'))}}</button>

                                                     </form>
                                                 @else
                                                     <form action="}" method="post" style="display: inline-block">
                                                         {{csrf_field()}}

                                                         <button type="submit" class="btn btn-danger btn-sm" disabled><i class="fa fa-trash"></i>  {{__(('site.delete'))}}</button>

                                                     </form>
                                                 @endif
                                                 {{--end of table--}}
                                             </td>


                                         </tr>
                                     @endforeach
                                 </table>
{{--                                 end of table--}}
                             </div>
{{--                             end of box body--}}
                         @else
                             <h3>{{__('site.no_data_found')}}</h3>
                             @endif
                     </div>
                </div>
                <div class="col-md-4">
                    <div class="box box-primary with-border">
                        <div class="box-header">
                            <h3 class="box-title">{{__('site.show_products')}}</h3>
                        </div>
                        {{--                    end of box header--}}
                        <div class="box-body">
                            <div style="display: none;flex-direction: column;align-items: center;" id="loading">
                                <div class="loader"></div>
                                <p>{{__('site.loading')}}</p>
                            </div>
                            <div id="order-product-list">

                            </div>

                        </div>
                    </div>
                    {{--                end of box--}}
                </div>
                {{--            end of col --}}
            </div>

            {{$orders->appends(request()->query())->links()}}
        </section>
@endsection
