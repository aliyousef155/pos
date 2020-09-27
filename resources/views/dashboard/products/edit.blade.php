@extends('dashboard.adminlayout.admin')


@section('content')
    <section class="content-header">
        <h1>
            {{__('site.edit')}}

        </h1>
        <ol class="breadcrumb">

            <li class=""><a href="{{route('dashboard.admin')}}">{{__('site.dashboard')}}</a></li>
            <li class=""><a href="{{route('dashboard.products.index')}}">{{__('site.products')}}</a></li>
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
                        <form action="{{route('dashboard.products.update',$product->id)}}" method="post" enctype="multipart/form-data">
                            {{csrf_field()}}
                            {{method_field('put')}}
                            <div class="form-group">
                                <label for="">{{__('site.categories')}}</label>
                                <select name="category_id" id="" class="form-control">
                                    <option value="">{{__('site.all_categories')}}</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" {{$product->category_id==$category->id ? 'selected':''}}>{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @foreach(config('translatable.locales') as $locale)
                                <div class="form-group">
                                    <label for="">{{__('site.name')}}</label>
                                    <input type="text" class="form-control" value="{{$product->translate($locale)->name}}" name="{{$locale}}[name]">
                                </div>
                                <div class="form-group">
                                    <label for="">{{__('site.'.$locale.'.description')}}</label>
                                    <textarea  class="form-control ckeditor"  name="{{$locale}}[description]" ></textarea>
                                </div>
                            @endforeach
                            <div class="form-group">
                                <label for="">{{__('site.image')}}</label>
                                <input type="file" class="form-control image" name="image" >
                            </div>
                            <div class="form-group">
                                <img src="{{$product->image_path}}" alt="" style="width: 100px" class="img-thumbnail image-preview">
                            </div>
                            <div class="form-group">
                                <label for="">{{__('site.purchase_price')}}</label>
                                <input type="number" name="purchase_price" class="form-control" value="{{$product->purchase_price}}">
                            </div>
                            <div class="form-group">
                                <label for="">{{__('site.sale_price')}}</label>
                                <input type="number" name="sale_price" class="form-control" value="{{$product->sale_price}}">
                            </div>
                            <div class="form-group">
                                <label for="">{{__('site.stock')}}</label>
                                <input type="number" name="stock" class="form-control" value="{{$product->stock}}">
                            </div>

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
