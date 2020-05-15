<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Search extends Model
{
    
    protected $searchables = ['client','office_levels'];
    public function search(){

        

    }
}
