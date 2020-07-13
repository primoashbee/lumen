<?php

namespace App\Http\Controllers;

use App\User;
use App\Client;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request){
        $q = $request->keyword;
        $filtered =[];

        $clients = [];
        $client_list = Client::search($q);
        
        
        $users = [];
        $user_list = User::search($q);
        

        if ($client_list != null) {
            
            $clients = $client_list->filter(function ($item) {
                return $item->level=="branch";
            })->values();
        
            $clients = $client_list->map(function ($item) {
                $client['id'] = $item->id;
                $client['name'] = $item->client_id . ' - ' . $item->firstname . ' ' . $item->lastname;
                $client['link'] = "/client/".$item->client_id;
                return $client;
            });

            $filtered[] = ['level' => 'Client', 'data' => collect($clients)->sortBy('name')->unique()->values()];
        }

        if($user_list!=null){
            
            $users = $user_list->map(function ($item) {
                $user['id'] = $item->id;
                $user['name'] = $item->id . ' - ' . $item->firstname . ' ' . $item->lastname;
                $user['link'] = "/user/".$item->id;
                return $user;
            });

            $filtered[] = ['level' => 'Users', 'data' => collect($users)->sortBy('name')->unique()->values()];
            
        }

        return $filtered;
    }   
}
