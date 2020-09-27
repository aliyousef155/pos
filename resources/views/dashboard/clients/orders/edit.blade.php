@extends('dashboard.adminlayout.admin')


@section('content')
    <section class="content-header">
        @if(Session::has('failed'))
            <div class="alert alert-danger fade-message" style="width: 60vh">
                <p >{{session('failed')}}</p>
            </div>
        @endif
        <h1>
            {{__('site.add')}}

        </h1>
        <ol class="breadcrumb">

            <li class=""><a href="{{route('dashboard.admin')}}">{{__('site.dashboard')}}</a></li>
            <li class=""><a href="{{route('dashboard.clients.index')}}">{{__('site.clients')}}</a></li>
            {{--            <li class=""><a href="{{route('dashboard.orders')}}">{{__('site.orders')}}</a></li>--}}
            <li class="active">{{__('site.add')}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary ">
                    <div class="box-header with-border">

                        <h2>{{__('site.categories')}}</h2>

                    </div>
                    {{--                   end of box header--}}
                    <div class="box-body">
                        @foreach($categories as $category)
                            <div class="panel-group">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" href="#{{str_replace(' ','-',$category->name)}}">{{$category->name}}</a>
                                        </h4>
                                    </div>

                                    <div class="panel-collapse collapse" id="{{str_replace(' ','-',$category->name)}}">
                                        <div class="panel-body">
                                            @if($category->products->count() > 0)
                                                <table class="table-hover table">
                                                    <tr>
                                                        <th>{{__('site.name')}}</th>
                                                        <th>{{__('site.stock')}}</th>
                                                        <th>{{__('site.price')}}</th>
                                                        <th>{{__('site.add')}}</th>
                                                    </tr>
                                                    @foreach($category->products as $product)
                                                        <tr>
                                                            <td>{{$product->name}}</td>
                                                            <td>{{$product->stock}}</td>
                                                            <td>{{$product->sale_price}}</td>
                                                            <td>
                                                                <a href=""
                                                                   id="product-{{$product->id}}"
                                                                   data-name="{{$product->name}}"
                                                                   data-id="{{$product->id}}"
                                                                   data-price="{{$product->sale_price}}"
                                                                   class="btn {{in_array($product->id,$order->products->pluck('id')->toArray()) ? 'btn-default disabled add-product-btn' : 'btn-success btn-sm add-product-btn'}}">
                                                                    <i class="fa fa-plus"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            @else
                                                <h5>{{__('site.no_records')}}</h5>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{--end of box body--}}
                </div>
                {{--                end of box--}}
            </div>
            {{--            end of col--}}


            <div class="col-md-6">
                <div class="box box-primary ">
                    <div class="box-header with-border">

                        <h2>{{__('site.orders')}}</h2>

                    </div>
                    {{--                   end of box header--}}
                    <div class="box-body with-border">
                        <form action="{{route('dashboard.clients.orders.update',['order'=>$order->id,'client'=>$client->id])}}"  method="post">
                            {{csrf_field()}}
                            {{method_field('put')}}
                            <div class="row">
                                <table class="table-hover table">
                                    <tr>
                                        <th>{{__('site.product')}}</th>
                                        <th>{{__('site.quantity')}}</th>
                                        <th>{{__('site.price')}}</th>
                                        <th>{{__('site.total')}}</th>
                                        <th>{{__('site.action')}}</th>
                                    </tr>
                                    <tbody class="order-list">
                                    @foreach($order->products as $product)
                                    <tr>
                                        <td>{{$product->name}}</td>

                                        <td><input type="number"  name="products[{{$product->id}}][quantity]" id="" data-price="{{$product->sale_price}}" class="form-control input-sm product-quantity" min="1" value="{{$product->pivot->quantity}}" max="{{$product->stock}}"></td>
                                        <td>{{$product->sale_price}}</td>
                                        <td class="product-price">{{$product->sale_price * $product->pivot->quantity}}</td>
                                        <td><button class="btn btn-danger btn-sm remove-product-button" data-id="{{$product->id}}"><span class="fa fa-trash"></span></button></td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>

                            </div>
                            {{--                        end of row--}}
                            <div class="row">
                                <div class="col-md-12">
                                    <p>{{__('site.final_total')}}: <span class="total-price">{{$order->total_price}}</span></p>
                                </div>
                            </div>
                            {{--  end of row--}}
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary btn-sm form-control disabled add-order-form-btn " type="submit"><i class="fa fa-edit"></i> {{__('site.edit_order')}}</button>
                                </div>
                            </div>
                            {{--  end of row--}}
                        </form>
                        {{--                        end of form--}}
                    </div>
                    {{--end of box body--}}
                </div>
                {{--                end of box--}}
            </div>
            {{--            end of col--}}
        </div>
        {{--        end of row--}}
        {{--    partials for errors--}}
        @include('dashboard/adminlayout/partial')
        {{--    /partials for errors--}}

    </section>
@endsection
