@extends('dashboard.adminlayout.admin')


@section('content')
    <section class="content-header">
        @if(Session::has('success'))
            <div class="alert alert-success fade-message" style="width: 60vh">
                <p >{{session::get('success')}}</p>
            </div>
        @endif
        <h1>
            {{__('site.products')}}

        </h1>
        <ol class="breadcrumb">

            <li class=""><a href="{{route('dashboard.admin')}}">{{__('site.dashboard')}}</a></li>
            <li class="active">{{__('site.products')}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                            <h3 class="box-title" style="margin-bottom: 15px"> {{__('site.products')}}  <small></small></h3>
                <form action="{{route('dashboard.products.index')}}" method="get" >
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="search" placeholder="{{__('site.search')}}" value="{{request()->search}}">
                        </div>

                        <div class="col-md-4">
                            <select name="category_id" id="" class="form-control">
                                <option value="" >{{__('site.choose_category')}}</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}" {{request()->category_id==$category->id ? 'selected':''}}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
{{--                          end of search field--}}
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i>{{__('site.search')}}</button>
                            @if(auth()->user()->hasPermission('products_create'))

                                <a href="{{route('dashboard.products.create')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus"> {{__('site.add')}}</i></a>
                            @else

                                <a href="" class="btn btn-primary btn-sm" disabled><i class="fa fa-plus" > {{__('site.add')}}</i></a>

                            @endif
                        </div>
{{--                        end of search button field--}}
                    </div>

                </form>

            </div>
{{--            end of box header--}}



            <div class="box-body">
                @if($products->count() > 0)
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('site.name')}}</th>
                            <th>{{__('site.description')}}</th>
                            <th>{{__('site.image')}}</th>
                            <th>{{__('site.purchase_price')}}</th>
                            <th>{{__('site.sale_price')}}</th>
                            <th>{{__('site.stock')}}</th>
                            <th>{{__('site.profit_percent')}}</th>
                            <th>{{__('site.action')}}</th>



                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $index=>$product)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$product->name}}</td>
                                <td> {!! $product->description !!} </td>
                                <td><img src="{{$product->image_path}}" class="thumbnail" style="width: 100px" alt=""></td>
                                <td>{{$product->purchase_price}}</td>
                                <td>{{$product->sale_price}}</td>
                                <td>{{$product->stock}}</td>
                                <td>{{$product->profit_percent.'%'}}</td>

                                <td>
                                    @if(auth()->user()->hasPermission('products_update'))
                                        <a href="{{route('dashboard.products.edit',$product->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> {{__('site.edit')}}</a>
                                    @else
                                        <a href="" class="btn btn-info btn-sm" disabled=""><i class="fa fa-edit"></i> {{__('site.edit')}}</a>
                                    @endif
                                    @if(auth()->user()->hasPermission('products_delete'))
                                        <form action="{{route('dashboard.products.destroy',$product->id)}}" method="post" style="display: inline-block">
                                            {{csrf_field()}}
                                            {{method_field('delete')}}
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> {{__(('site.delete'))}}</button>

                                        </form>
                                    @else
                                        <form action="" method="post" style="display: inline-block">
                                            {{csrf_field()}}
                                            {{method_field('delete')}}
                                            <button type="submit" class="btn btn-danger btn-sm" disabled><i class="fa fa-trash"></i>  {{__(('site.delete'))}}</button>

                                        </form>
                                    @endif
{{--                                    end of table--}}
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                    {{$products->appends(request()->query())->links()}}
                @else
                    <h2>{{__('site.no_data_found')}}</h2>
                @endif
{{--                end of table--}}
            </div>
{{--            end of box body--}}
        </div>
{{--        end of box--}}


    </section>
@endsection
