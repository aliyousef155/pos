<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

//use Intervention\Image\Image;

class UsersController extends Controller
{
public  function __construct()
{
    $this->middleware(['permission:users_read'])->only('index');
    $this->middleware(['permission:users_create'])->only('create');
    $this->middleware(['permission:users_update'])->only('edit');
}//end of construct

    public function index(request $request)
    {
        $users=User::whereRoleIs('admin')->where(function ($q)use($request) {
            return $q->when($request->search, function ($query) use ($request) {
                return $query->where('first_name', 'like', '%' . $request->search . '%')->orWhere('last_name', 'like', '%' . $request->search . '%');
            });
             })->latest()->paginate(5);
        return view('dashboard.users.index',compact('users'));
    }//end of index


    public function create()
    {
        $users=User::all();
        return view('dashboard.users.create',compact('users'));
    }//end of create function


    public function store(Request $request)
    {

        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>'required|unique:users',
            'image'=>'image|required',
            'password'=>'required|confirmed',
            'permissions'=>'required|min:1',

        ]);
        $request_data=$request->except(['password','password_confirmation','permissions','image']);
        $request_data['password']=bcrypt($request->password);
        if ($request->image){
            Image::make($request->image)->resize(300,null,function ($constraint){
               $constraint->aspectRatio();
            })->save(public_path('uploads/users_images/'.$request->image->hashName()));
        }//end of request image
            $request_data['image']=$request->image->hashName();

        $user=User::create($request_data);
        $user->attachRole('admin');

        $user->syncPermissions($request->permissions);

        session()->flash('success',__('site.added_successfully'));
        return redirect()->route('dashboard.users.index');
    }


    public function show(User $user)
    {
        //
    }


    public function edit(User $user)
    {

        return view('dashboard.users.edit',compact('user'));
    }//end of edit


    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name'=>'required',
            'last_name'=>'required',
            'email'=>['required', Rule::unique('users')->ignore($user->id),],
            'image'=>'image',
            'permissions'=>'required|min:1',
        ]);
        $request_data=$request->except(['permissions','image']);



        //store the image
        if ($request->image!=''){
            if ($user->image !='no-user.jpg'){
                Storage::disk('public_uploads')->delete('/users_images/'.$user->image);
            }
            Image::make($request->image)->resize(300,null,function ($constraint){
                $constraint->aspectRatio();
            })->save(public_path('uploads/users_images/'.$request->image->hashName()));
            $request_data['image']=$request->image->hashName();

        }else{
            $request_data['image']=$user->image ;
        }//end of request image



        $user->update($request_data);

        $user->syncPermissions($request->permissions);


        session()->flash('success',__('site.updated_successfully'));

        return redirect()->route('dashboard.users.index');
    }//end of update


    public function destroy(User $user)
    {
        if ($user->image != 'no-user.jpg'){
            Storage::disk('public_uploads')->delete('/users_images/'.$user->image);
        }
        $user->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('dashboard.users.index');
    }//end of delete
}
