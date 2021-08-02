<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTenantRequest;
use App\Http\Requests\UpdateTenantRequest;
use App\Notifications\TenantInvateNotification;

class TenantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->domain!=null){
            abort(401);
        }
        $tenants=User::where('role_id',2)->get();
        return view('Tenant.index',compact('tenants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Tenant.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTenantRequest $request)
    {
        $user=User::create($request->validated()+['role_id'=>2,'password'=>'secret']);
        $url=URL::signedRoute('invitation',$user);
        $user->notify(new TenantInvateNotification($url));
        return redirect()->route('tenants.index');
    }

    

    /**
     * Show the form for editing the specified resource.
     *
      *  @param  User  $tenant
     * @return \Illuminate\Http\Response
     */
    public function edit( User $tenant)
    {
        
        return view('Tenant.edit',compact('tenant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  User  $tenant
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTenantRequest $request, User $tenant)
    {
        $tenant->update($request->validated());
        return redirect()->route('tenants.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $tenant)
    {
        $tenant->delete();
        return redirect()->route('tenants.index');
        //
    }
    public function invitation(User $user, Request $req){
        
         if($user->password!='secret'|| !request()->hasValidSignature() ){
            return abort(401);
        
         }
         Auth::login($user);
         return redirect()->route('setpassword');
         


    }
}
