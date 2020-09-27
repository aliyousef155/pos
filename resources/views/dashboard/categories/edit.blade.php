@extends('dashboard.adminlayout.admin')


@section('content')
    <section class="content-header">
        <h1>
            {{__('site.edit')}}

        </h1>
        <ol class="breadcrumb">

            <li class=""><a href="{{route('dashboard.admin')}}">{{__('site.dashboard')}}</a></li>
            <li class=""><a href="{{route('dashboard.categories.index')}}">{{__('site.categories')}}</a></li>
            <li class="active">{{__('site.edit')}}</li>
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
                        <form action="{{route('dashboard.categories.update',$category_data->id)}}" method="post" >
                            {{csrf_field()}}
                            {{method_field('put')}}
                            @foreach(config('translatable.locales') as $locale)
                                <div class="form-group">
                                    <label for="">{{__('site.name')}}</label>
                                    <input type="text" class="form-control" value="{{$category_data->translate($locale)->name}}" name="{{$locale}}[name]">
                                </div>
                            @endforeach

                            <div class="form-group">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-edit"> {{__('site.edit')}}</i></button>
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
