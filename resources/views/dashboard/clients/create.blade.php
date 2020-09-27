@extends('dashboard.adminlayout.admin')


@section('content')
    <section class="content-header">
        <h1>
            {{__('site.add')}}

        </h1>
        <ol class="breadcrumb">

            <li class=""><a href="{{route('dashboard.admin')}}">{{__('site.dashboard')}}</a></li>
            <li class=""><a href="{{route('dashboard.clients.index')}}">{{__('site.clients')}}</a></li>
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
                        <form action="{{route('dashboard.clients.store')}}" method="post" >
                            {{csrf_field()}}

                         <div class="form-group">
                             <label for="">{{__('site.name')}}</label>
                             <input type="text" name="name" class="form-control" value="{{old('name')}}">
                         </div>

                          @for($i=0;$i<2;$i++)
                                <div class="form-group">
                                    <label for="">{{__('site.phone')}}</label>
                                    <input type="text" name="phone[]" class="form-control" >
                                </div>

                            @endfor


                          <div class="form-group">
                             <label for="">{{__('site.address')}}</label>
                                <input type="text" name="address" class="form-control" value="{{old('address')}}" >
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
