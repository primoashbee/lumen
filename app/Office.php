<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    // protected $with = ['parent'];
    protected $fillable = ['name','code','parent_id','level'];
    protected $schema;

    public function parent(){
        return $this->belongsTo(static::class, 'parent_id');
    }
    
    public function children(){
        return $this->hasMany(static::class, 'parent_id');
    }   

    public function user(){
        return $this->belongsToMany(User::class);
    }

    public function clients(){
        return $this->hasMany(Client::class);
    }

    public function staffs(){
        return $this->belongsToMany(User::class);
    }


    public function getChildIDS(){
        $children = $this->children;
        
        $count = $this->children->count();
        $ids = [];
        //if ($count>0) {
            foreach ($children as $child) {
                array_push($ids,$child->id);
                $ids = array_merge($ids, $child->getChildIDS());
            }
        //}

        return $ids;
    }

    public function getChild(){
        $children = $this->children;
        
        // $count = $this->children->count();
        $result = [];
        //if ($count>0) {
            foreach ($children as $child) {
                array_push($result,$child);
                $result = array_merge($result, $child->getChild());
            }
        //}

        return $result;
    }
    public function getAllChildren(){
        $children = $this->children;
        $ids = [];
            foreach ($children as $child) {
                array_push($ids,$child);
                $ids = array_merge($ids, $child->getAllChildren());
            }
        return $ids;
    }
    public function getAllChildrenIDS(){
        $children = $this->children;
        $ids = [];
            foreach ($children as $child) {
                array_push($ids,$child->id);
                $ids = array_merge($ids, $child->getAllChildrenIDs());
            }
        return $ids;
    }
    //parameters insert_self if we want to add the parent id to the return lower office ids
    public function getLowerOfficeIDS($insert_self = true){
        $id = $this->id;
        $child_ids = $this->getAllChildrenIDS();
        if ($insert_self) {
            return array_merge($child_ids, [$id]);
        }
        return $child_ids;
    }
    public function getParent(){
        return $this->parent;
    }
    public function getBranch(){
        $parents = [];
        echo $this->name;
        if($this->level=="branch"){
            return 'nice';
        }

        array_push($parents, $this);
        $this->getBranch();
        return $parents;
    
                
    }

    function getTopOffice($level="main_office"){
        if($this->level=="branch"){
            return $this;
        }
        $parent = $this->getParent();
        if($parent == null){
            return $parent;
        }
        if($parent->level == $level){
         return $parent;
        }else{
            return  $parent->getTopOffice($level);
        }
    }
    
    public function generateClientID(){
        
    }


    public static function schema(){
    $schema = array(array(
                    "level"=>"main_office",
                    "parent"=>null
                ),
                array(
                    "level"=>"region",
                    "parent"=>"main_office"
                ),
                array(
                    "level"=>"area",
                    "parent"=>"region",
                ),
                array(
                    "level"=>"branch",
                    "parent"=>"area",
                ),
                array(
                    "level"=>"unit",
                    "parent"=>"branch",
                ),
                array(
                    "level"=>"cluster",
                    "parent"=>"unit",
                ),
                array(
                    "level"=>"account_officer",
                    "parent"=>"branch",
                )
            );
            
        return collect($schema);
    }

    public static function getParentOfLevel($level){
        $me = new static;
        $schema = $me->schema();
        $curr_level =  $schema->filter(function($item) use ($level){
            return $item['level'] == $level;
        })->values();
        return $curr_level->first()['parent'];
    }
}
