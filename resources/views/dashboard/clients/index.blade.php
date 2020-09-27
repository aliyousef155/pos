@extends('dashboard.adminlayout.admin')


@section('content')
    <section class="content-header">
        @if(Session::has('success'))
            <div class="alert alert-success fade-message" style="width: 60vh">
                <p >{{session('success')}}</p>
            </div>
        @endif
        <h1>
            {{__('site.clients')}}

        </h1>
        <ol class="breadcrumb">

            <li class=""><a href="{{route('dashboard.admin')}}">{{__('site.dashboard')}}</a></li>
            <li class="active">{{__('site.clients')}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                {{--            <h3 class="box-title" style="margin-bottom: 15px"> {{__('site.clients')}}  <small>{{$clients->total()}}</small></h3>--}}
                <form action="{{route('dashboard.clients.index')}}" method="get" >
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="search" placeholder="{{__('site.search')}}" value="{{request()->search}}">
                        </div>
                        {{--  end of search field--}}
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i>{{__('site.search')}}</button>
                            @if(auth()->user()->hasPermission('clients_create'))

                                <a href="{{route('dashboard.clients.create')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus"> {{__('site.add')}}</i></a>
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
                @if($clients->count() > 0)
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('site.name')}}</th>
                            <th>{{__('site.address')}}</th>
                            <th>{{__('site.phone')}}</th>

                                @if(auth()->user()->hasPermission('orders_create'))
                                <th>
                                {{__('site.add_order')}}
                                </th>
                                @endif

                            <th>{{__('site.action')}}</th>



                        </tr>
                        </thead>
                        <tbody>
                        @foreach($clients as $index=>$client)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$client->name}}</td>
                                <td>{{$client->address}}</td>
                                <td>{{implode(array_filter($client->phone),'-')}}</td>

                                    @if(auth()->user()->hasPermission('orders_create'))
                                    <td>
                                    <a href="{{route('dashboard.clients.orders.create',$client->id)}}" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> {{__('site.add_order')}}</a>
                                    </td>
                                      @endif

                                <td>
                                    @if(auth()->user()->hasPermission('clients_update'))
                                        <a href="{{route('dashboard.clients.edit',$client->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> {{__('site.edit')}}</a>
                                    @else
                                        <a href="" class="btn btn-info btn-sm" disabled=""><i class="fa fa-edit"></i> {{__('site.edit')}}</a>
                                    @endif
                                    @if(auth()->user()->hasPermission('clients_delete'))
                                        <form action="{{route('dashboard.clients.destroy',$client->id)}}" method="post" style="display: inline-block">
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
                    {{$clients->appends(request()->query())->links()}}
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
