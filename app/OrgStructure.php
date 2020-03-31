<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrgStructure extends Model
{

    protected $structure;
    
    public function parent(){
        return $this->belongsTo(static::class, 'parent_id');
    }
    
    public function children(){
        return $this->hasMany(static::class, 'parent_id');
    }  

    public function __construct(){
        $this->structure = collect(array([
            "level"=>"main_office",
            "parent"=>null,
            "child"=> array([
                "level"=>"region",
                "parent"=>"main_office"
            ])
        ]));
    }
    
    public static function hey(){
        return 'hey';
    }
}
