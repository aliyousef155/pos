@extends('dashboard.adminlayout.admin')


@section('content')
    <section class="content-header">
        @if(Session::has('success'))
            <div class="alert alert-success fade-message" style="width: 60vh">
                <p >{{session('success')}}</p>
            </div>
        @endif
        <h1>
            {{__('site.categories')}}

        </h1>
        <ol class="breadcrumb">

            <li class=""><a href="{{route('dashboard.admin')}}">{{__('site.dashboard')}}</a></li>
            <li class="active">{{__('site.categories')}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                {{--            <h3 class="box-title" style="margin-bottom: 15px"> {{__('site.categories')}}  <small>{{$categories->total()}}</small></h3>--}}
                <form action="{{route('dashboard.categories.index')}}" method="get" >
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="search" placeholder="{{__('site.search')}}" value="{{request()->search}}">
                        </div>
                        {{--  end of search field--}}
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i>{{__('site.search')}}</button>
                            @if(auth()->user()->hasPermission('categories_create'))

                                <a href="{{route('dashboard.categories.create')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus"> {{__('site.add')}}</i></a>
                            @else

                                <a href="" class="btn btn-primary btn-sm" disabled><i class="fa fa-plus" > {{__('site.add')}}</i></a>

                            @endif
                        </div>
                        {{--end of search button field--}}
                    </div>

                </form>

            </div>
            {{--end of box header--}}



            <div class="box-body">
                @if($categories->count() > 0)
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('site.name')}}</th>
                            <th>{{__('site.products_count')}}</th>
                            <th>{{__('site.related_products')}}</th>
                            <th>{{__('site.action')}}</th>



                        </tr>
                        </thead>
                        <tbody>
                        @foreach($categories as $index=>$category)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$category->name}}</td>
                                <td>{{$category->products()->count()}}</td>
                                <td><a href="{{route('dashboard.products.index',['category_id'=>$category->id])}}" class="btn btn-info btn-sm">{{__('site.related_products')}}</a></td>

                                <td>
                                    @if(auth()->user()->hasPermission('categories_update'))
                                        <a href="{{route('dashboard.categories.edit',$category->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> {{__('site.edit')}}</a>
                                    @else
                                        <a href="" class="btn btn-info btn-sm" disabled=""><i class="fa fa-edit"></i> {{__('site.edit')}}</a>
                                    @endif
                                    @if(auth()->user()->hasPermission('categories_delete'))
                                        <form action="{{route('dashboard.categories.destroy',$category->id)}}" method="post" style="display: inline-block">
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
                                    {{--end of table--}}
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                    {{$categories->appends(request()->query())->links()}}
                @else
                    <h2>{{__('site.no_data_found')}}</h2>
                @endif
                {{--end of table--}}
            </div>
            {{--end of box body--}}
        </div>
        {{--end of box --}}


    </section>
@endsection
