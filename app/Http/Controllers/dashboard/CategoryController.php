<?php

namespace App\Http\Controllers\dashboard;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public  function __construct()
    {
        $this->middleware(['permission:categories_read'])->only('index');
        $this->middleware(['permission:categories_create'])->only('create');
        $this->middleware(['permission:categories_update'])->only('edit');
    }//end of construct
    public function index(request $request)
    {
        $categories=Category::when($request->search,function ($q)use ($request){
           return $q->whereTranslationLike('name','%'.$request->search.'%');
        })->latest()->paginate(5);

        return view('dashboard.categories.index',compact('categories'));
    }//end of index function


    public function create()
    {
        $categories=Category::all();
        return view('dashboard.categories.create',compact('categories'));
    }//end of create function


    public function store(Request $request)
    {

        $request->validate([
           'ar.*'=>'required|unique:category_translations',
           'en.*'=>'required|unique:category_translations',
        ]);
        Category::create($request->all());
        session()->flash('success',__('site.added_successfully'));
        return redirect()->route('dashboard.categories.index');
    }//end of store function



    public function edit($category)
    {
        $category_data= Category::find($category);
        return view('dashboard.categories.edit',compact('category_data'));
    }// end of edit


    public function update(Request $request,  $category)
    {
        $category_data=Category::find($category);
        $request->validate([
            'ar.*'=>['required',Rule::unique('category_translations','name')->ignore($category_data->id,'category_id')],
            'en.*'=>['required',Rule::unique('category_translations','name')->ignore($category_data->id,'category_id')],
        ]);
        $category_data->update($request->all());
        session()->flash('success',__('site.updated_successfully'));
        return redirect()->route('dashboard.categories.index');
    }// end of update


    public function destroy( $category)
    {
        $category_data=Category::find($category);
        $category_data->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('dashboard.categories.index');
    }//end of delete
}
