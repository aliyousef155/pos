<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\client;
use Illuminate\Http\Request;

class ClientController extends Controller
{  public  function __construct()
{
    $this->middleware(['permission:clients_read'])->only('index');
    $this->middleware(['permission:clients_create'])->only('create');
    $this->middleware(['permission:clients_update'])->only('edit');
}//end of construct

    public function index(request $request)
    {

        $clients=Client::when($request->search,function ($q) use ($request){
            return $q->where('name','like','%'.$request->search.'%')->
            orWhere('phone','like','%'.$request->search.'%')->
            orWhere('address','like','%'.$request->search.'%');
        })->latest()->paginate(5);
        return view('dashboard.clients.index',compact('clients'));
    }//end of index

    public function create()
    {
        return view('dashboard.clients.create');
    }//end of create

    public function store(Request $request)
    {

        $request->validate([
           'name'=>'required',
           'address'=>'required',
           'phone'=>'required|array|min:1',
           'phone.0'=>'required|',
        ]);
        Client::create($request->all());
        session()->flash('success',__('site.added_successfully'));
        return redirect()->route('dashboard.clients.index');
    }//end of store





    public function edit(client $client)
    {
        return view('dashboard.clients.edit',compact('client'));
    }//end of edit


    public function update(Request $request, client $client)
    {
        $request->validate([
            'name'=>'required',
            'address'=>'required',
            'phone'=>'required|array|min:1',
            'phone.0'=>'required|',
        ]);
        $client->update($request->all());
        session()->flash('success',__('site.updated_successfully'));
        return redirect()->route('dashboard.clients.index');

    }//end of update


    public function destroy(client $client)
    {
        $client->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('dashboard.clients.index');

    }//end of destroy
}//end of controller
