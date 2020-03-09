<?php

namespace App\Http\Controllers;

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

    public function branches(){ 
        // return array(
        //     array(
        //         'level'=>'Javascript',
        //         'data' => array(
        //             array('name'=>'Vue.js','category'=>'front-end'),
        //             array('name'=>'Adonis','category'=>'backend'),
        //         )
        //     ),
        //     array(
        //         'level'=>'ex',
        //         'data' => array(
        //             array('name'=>'a.js','category'=>'front-end'),
        //             array('name'=>'d','category'=>'backend'),
        //         )
        //     )
        // );
        return auth()->user()->scopesBranch();
    }
}
