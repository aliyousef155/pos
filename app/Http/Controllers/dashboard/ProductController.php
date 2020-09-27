<?php

namespace App\Http\Controllers\dashboard;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public  function __construct()
    {
        $this->middleware(['permission:products_read'])->only('index');
        $this->middleware(['permission:products_create'])->only('create');
        $this->middleware(['permission:products_update'])->only('edit');
    }//end of construct

    public function index(request $request)
    {
        $categories=Category::all();


        $products=Product::when($request->search,function ($q)use ($request){

            return $q->whereTranslationLike('name','%'.$request->search.'%');

        })->when($request->category_id,function ($q) use ($request){
            return $q->where('category_id',$request->category_id);

        })->latest()->paginate(5);
        return view('dashboard.products.index',compact('categories','products'));
    }//end of index


    public function create()
    {
        $categories=Category::all();
        return view('dashboard.products.create',compact('categories'));

    }//end of create


    public function store(Request $request)
    {
        $rules=[
            'category_id'=>'required'
        ];
        foreach (config('translatable.locales')as $locale){
            $rules+=[$locale.'.name'=>'required|unique:product_translations,name'];
            $rules+=[$locale.'.description'=>'required'];

        }// end foreach
        $rules+=[
            'image'=>'required|image',
            'purchase_price'=>'required',
            'sale_price'=>'required',
            'stock'=>'required',
        ];
        $request->validate($rules);

        $request_data=$request->all();
        if ($request->image){
            Image::make($request->image)->resize(300,null,function ($constraint){
                $constraint->aspectRatio();
            })->save(public_path('uploads/products_images/'.$request->image->hashName()));
        }//end of request image
        $request_data['image']=$request->image->hashName();

        Product::create($request_data);
        session()->flash('success',__('site.added_successfully'));
        return redirect()->route('dashboard.products.index');

    }// end of store





    public function edit(Product $product)
    {
        $categories=Category::all();
        return view('dashboard.products.edit',compact('product','categories'));
    }//end of edit


    public function update(Request $request, Product $product)
    {

        $rules=[
            'category_id'=>'required'
        ];
        foreach (config('translatable.locales')as $locale){
            $rules+=[$locale.'.name'=>'required',Rule::unique('products')->ignore($product->id)];
            $rules+=[$locale.'.description'=>'required'];

        }// end foreach
        $rules+=[
            'purchase_price'=>'required',
            'sale_price'=>'required',
            'stock'=>'required',
            'image'=>'image',
        ];
        $request->validate($rules);

        $request_data=$request->all();

        //store the image
        if ($request->image!=''){
            if ($product->image !='no-user.jpg'){
                Storage::disk('public_uploads')->delete('/products_images/'.$product->image);
            }
            Image::make($request->image)->resize(300,null,function ($constraint){
                $constraint->aspectRatio();
            })->save(public_path('uploads/products_images/'.$request->image->hashName()));
            $request_data['image']=$request->image->hashName();

        }else{
            $request_data['image']=$product->image ;
        }//end of request image

        $product->update($request_data);
        session()->flash('success',__('site.added_successfully'));
        return redirect()->route('dashboard.products.index');
    }//end of update


    public function destroy(Product $product)
    {
        Storage::disk('public_uploads')->delete('/products_images/'.$product->image);
        $product->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('dashboard.products.index');
    }// end of destroy
}//end of controller
