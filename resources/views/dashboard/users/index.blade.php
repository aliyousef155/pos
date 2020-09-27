@extends('dashboard.adminlayout.admin')


@section('content')
    <section class="content-header">
        @if(Session::has('success'))
            <div class="alert alert-success fade-message" style="width: 60vh">
                <p >{{session('success')}}</p>
            </div>
        @endif
        <h1>
            {{__('site.users')}}

        </h1>
        <ol class="breadcrumb">

            <li class=""><a href="{{route('dashboard.admin')}}">{{__('site.dashboard')}}</a></li>
            <li class="active">{{__('site.users')}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                {{--            <h3 class="box-title" style="margin-bottom: 15px"> {{__('site.users')}}  <small>{{$users->total()}}</small></h3>--}}
                <form action="{{route('dashboard.users.index')}}" method="get" >
                    {{csrf_field()}}
                    <div class="row">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="search" placeholder="{{__('site.search')}}" value="{{request()->search}}">
                        </div>
                        {{--  end of search field--}}
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i>{{__('site.search')}}</button>
                            @if(auth()->user()->hasPermission('users_create'))

                                <a href="{{route('dashboard.users.create')}}" class="btn btn-primary btn-sm"><i class="fa fa-plus"> {{__('site.add')}}</i></a>
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
                @if($users->count() > 0)
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>{{__('site.first_name')}}</th>
                            <th>{{__('site.last_name')}}</th>
                            <th>{{__('site.email')}}</th>
                            <th>{{__('site.image')}}</th>
                            <th>{{__('site.action')}}</th>


                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $index=>$user)
                            <tr>
                                <td>{{$index+1}}</td>
                                <td>{{$user->first_name}}</td>
                                <td>{{$user->last_name}}</td>
                                <td>{{$user->email}}</td>
                                <td><img src="{{$user->image_path}}" alt="" style="width: 100px"></td>
                                <td>
                                    @if(auth()->user()->hasPermission('users_update'))
                                        <a href="{{route('dashboard.users.edit',$user->id)}}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i> {{__('site.edit')}}</a>
                                    @else
                                        <a href="" class="btn btn-info btn-sm" disabled=""><i class="fa fa-edit"></i> {{__('site.edit')}}</a>
                                    @endif
                                    @if(auth()->user()->hasPermission('users_delete'))
                                        <form action="{{route('dashboard.users.destroy',$user->id)}}" method="post" style="display: inline-block">
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
                    {{$users->appends(request()->query())->links()}}
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
