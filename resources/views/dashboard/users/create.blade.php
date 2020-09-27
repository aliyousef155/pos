@extends('dashboard.adminlayout.admin')


@section('content')
    <section class="content-header">
        <h1>
            {{__('site.add')}}

        </h1>
        <ol class="breadcrumb">

            <li class=""><a href="{{route('dashboard.admin')}}">{{__('site.dashboard')}}</a></li>
            <li class=""><a href="{{route('dashboard.users.index')}}">{{__('site.users')}}</a></li>
            <li class="active">{{__('site.add')}}</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">

                {{--    partials for errors--}}
                @include('dashboard/adminlayout/partial')
                {{--    /partials for errors--}}

            </div>
            {{--end of box header--}}



            <div class="box-body">
                <div class="row">
                    <div class="col-md-8">
                        <form action="{{route('dashboard.users.store')}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="">{{__('site.first_name')}}</label>
                                <input type="text" class="form-control" value="{{old('first_name')}}" name="first_name">
                            </div>

                            <div class="form-group">
                                <label for="">{{__('site.last_name')}}</label>
                                <input type="text" class="form-control" value="{{old('last_name')}}" name="last_name">
                            </div>

                            <div class="form-group">
                                <label for="">{{__('site.email')}}</label>
                                <input type="text" class="form-control" value="{{old('email')}}" name="email">
                            </div>
                            <div class="form-group">
                                <label for="">{{__('site.image')}}</label>
                                <input type="file" class="form-control image" name="image" >
                            </div>
                            <div class="form-group">
                                <img src="{{asset('uploads/users_images/no-user.jpg')}}" alt="" style="width: 100px" class="img-thumbnail image-preview">
                            </div>

                            <div class="form-group">
                                <label for="">{{__('site.password')}}</label>
                                <input type="password" class="form-control"  name="password">
                            </div>

                            <div class="form-group">
                                <label for="">{{__('site.password_confirmation')}}</label>
                                <input type="password" class="form-control"  name="password_confirmation">
                            </div>
                            <div class="form-group">
                                <label for="">{{__('site.permissions')}}</label>
                                <div class="nav-tabs-custom">
                                    @php
                                        $models=['users','categories','products','clients','orders'];
                                        $maps=['create','read','update','delete'];
                                    @endphp

                                    <ul class="nav nav-tabs">
                                        @foreach($models as $index=>$model)
                                            <li class="{{$index==0 ? 'active':''}}"><a href="#{{$model}}" data-toggle="tab">{{__('site.'.$model)}} </a></li>
                                        @endforeach


                                    </ul>
                                    <div class="tab-content">
                                        @foreach($models as  $index=>$model)
                                            <div class="tab-pane {{$index==0 ? 'active' : ''}}" id="{{$model}}">
                                                @foreach($maps as $index=>$map)
                                                    <label for=""><input type="checkbox" value="{{$model.'_'.$map}}" name="permissions[]"> {{__('site.'.$map)}}</label>
                                                @endforeach


                                            </div>
                                        @endforeach

                                    </div>
                                    <!-- /.tab-content -->
                                </div>  <!-- /.nav tabs -->
                            </div>



                            <div class="form-group">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-plus"> {{__('site.add')}}</i></button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
            {{--end of box body--}}
        </div>
        {{--end of box --}}


    </section>
@endsection
