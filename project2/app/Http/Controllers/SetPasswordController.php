<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetPasswordController extends Controller
{
    public function create(){
        return view('auth.setpassword');
    }
    public function store(StorePasswordRequest $req){
        auth()->user()->update([
           'password'=>bcrypt($req->password)
        ]);
        
        return redirect()->route('home')->with('status','Password set Succefully');


    }

}
