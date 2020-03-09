<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    
    public function index(){
        $branches = auth()->user()->scopesBranch();
        return view('pages.create-client',compact('branches'));
    }
    
    public function create(Request $request){
        dd($request->all());
    }
}
