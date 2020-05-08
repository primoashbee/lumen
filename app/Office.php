<?php

namespace App;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    // protected $with = ['parent'];
    protected $fillable = ['name','code','parent_id','level'];
    protected $schema;
    protected $searchables = [
        'name',
    ];

    public static function levelCount($level){
        $me = new static;
        return $me->where('level',$level)->count();
    }
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
        
        if($this->level==$level){
            return $this;
        }
        $parent = $this->getParent();
        if($parent == null){
            return $parent;
        }
        if($parent->level == $level){
         return $parent;
        }else{
            return $parent->getTopOffice($level);
        }
    }

    public static function schema(){
    $schema = array(array(
                    "level"=>"main_office",
                    "parent"=>null,
                    "children" =>['region','area','branch','unit','cluster','account_officer']
                ),
                array(
                    "level"=>"region",
                    "parent"=>"main_office",
                    "children" =>['area','branch','unit','cluster','account_officer']
                ),
                array(
                    "level"=>"area",
                    "parent"=>"region",
                    "children" =>['branch','unit','cluster','account_officer']
                ),
                array(
                    "level"=>"branch",
                    "parent"=>"area",
                    "children" =>['unit','cluster','account_officer']
                ),
                array(
                    "level"=>"unit",
                    "parent"=>"branch",
                    "children" =>['cluster']
                ),
                array(
                    "level"=>"cluster",
                    "parent"=>"unit",
                    "children" =>[]
                ),
                array(
                    "level"=>"account_officer",
                    "parent"=>"branch",
                    "children" =>[]
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
    public static function isChildOf($parent_level, $level){
        $me = new static;
        $schema = $me->schema();
         
        $list = $schema->filter(function($item) use ($parent_level){
            if ($item['level']==$parent_level) {
                return $item;
            }
        })->values()->first()['children'];
    
        return in_array($level,$list) ? true : false;
    }

    public static function like($level, $query){
        $me = new static;
        $searchables = $me->searchables;
       
        $office = Office::where('level', $level)->get();
        
        if(count($office)>0){
            if($query!=null){
                $office = Office::with('parent')->where('level',$level)->where(function(Builder $dbQuery) use($searchables, $query){
                    foreach($searchables as $item){  
                        $dbQuery->where($item,'LIKE','%'.$query.'%');
                    }
                });
                return $office;
            }
            $office = Office::with('parent')->where('level',$level);
            return $office;
        }
    }

}
