<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function users(){
        $users = User::all();
        return view('pages.users.users',compact('users'));
    }

    public function authStructure(){
      
        return auth()->user()->scopes();
    }

    public function branches(Request $request){
        return auth()->user()->scopesBranch($request->level);
    }

    public function get(Request $request, User $user){
        return $user;
    }
}
