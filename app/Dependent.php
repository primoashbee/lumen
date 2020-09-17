<?php

namespace App;

use stdClass;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Dependent extends Model
{
    protected $fillable = [
        'client_id',
        'package_id',
        'unit_of_plan',
        'application_number',

        'spouse_exists',
        'spouse_firstname',
        'spouse_middlename',
        'spouse_lastname',
        'spouse_birthday',

        'father_exists',
        'father_firstname',
        'father_middlename',
        'father_lastname',
        'father_birthday',

        'mother_exists',
        'mother_firstname',
        'mother_middlename',
        'mother_lastname',
        'mother_birthday',

        'sibling_1_exists',
        'sibling_1_firstname',
        'sibling_1_middlename',
        'sibling_1_lastname',
        'sibling_1_birthday',

        'sibling_2_exists',
        'sibling_2_firstname',
        'sibling_2_middlename',
        'sibling_2_lastname',
        'sibling_2_birthday',

        'sibling_3_exists',
        'sibling_3_firstname',
        'sibling_3_middlename',
        'sibling_3_lastname',
        'sibling_3_birthday',

        'child_1_exists',
        'child_1_firstname',
        'child_1_middlename',
        'child_1_lastname',
        'child_1_birthday',

        'child_2_exists',
        'child_2_firstname',
        'child_2_middlename',
        'child_2_lastname',
        'child_2_birthday',

        'child_3_exists',
        'child_3_firstname',
        'child_3_middlename',
        'child_3_lastname',
        'child_3_birthday',

        'common_illness',
        'commonillness_rate',
        'active',
        'created_by'
        
    ];
    public $fields = ['firstname','middlename','lastname','birthday'];
    protected $appends =['pivot_list'];
    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function relationship(){
        $list = [];
        if($this->spouse_exists){
            array_push($list,'spouse');
        }
        if($this->father_exists){
            array_push($list,'father');
        }
        if($this->mother_exists){
            array_push($list,'mother');
        }
        if($this->child_1_exists){
            array_push($list,'child_1');
        }
        if($this->child_2_exists){
            array_push($list,'child_2');
        }
        if($this->child_3_exists){
            array_push($list,'child_3');
        }
        if($this->sibling_1_exists){
            array_push($list,'sibling_1');
        }
        if($this->sibling_2_exists){
            array_push($list,'sibling_2');
        }
        if($this->sibling_3_exists){
            array_push($list,'sibling_3');
        }
        return $list;
    }
    
    public function formatList(){
        $relationships = $this->relationship();
        $fields = $this->fields;
        $dependents = new stdClass();
        foreach($relationships as $relationship){
            $dependents->$relationship = new stdClass();
            
            foreach($fields as $field){
                $column = $relationship.'_'.$field;
                $dependents->$relationship->$field = 1;
                $dependents->$relationship->$field = (object) array($field=>$this->pluck($column));
                
            }
        }
        return $dependents;
    }

    public function numberOfDependents(){
        $relationships = $this->relationship();
        $count = 0;
        foreach($relationships as $relationship){
            if($this->pluck($relationship."_exists")){
                $count++;
            }
        }
        return $count;
    }
    public function pivotList(){
        $relationships = $this->relationship();
        $fields = $this->fields;

        $list  =[];
        foreach($relationships as $relationship){
            $name =$this->pluck($relationship.'_lastname')->first().', '.$this->pluck($relationship.'_firstname')->first().', '.$this->pluck($relationship.'_middlename')->first()[0].'.';
            $list[] = (object) array(
                'application_number'=>$this->application_number,
                // 'application_number'=>'TAE',
                'firstname'=>$this->pluck($relationship.'_firstname')->first(),
                'middlename'=>$this->pluck($relationship.'_middlename')->first(),
                'mi'=>$this->pluck($relationship.'_middlename')->first()[0],
                'lastname'=>$this->pluck($relationship.'_lastname')->first(),
                'birthday'=>$this->pluck($relationship.'_birthday')->first(),  
                'name'=>$name,
                'relationship'=>ucfirst(str_replace('_', ' ',$relationship)),
                'age'=>Carbon::parse($this->pluck($relationship.'_birthday')->first())->age,
                'unit_of_plan'=>$this->pluck('unit_of_plan')->first(),
                
            );
        }
       return collect($list);
    }

    public function getPivotListAttribute(){
        return $this->pivotList();
    }

    public static function clientHasActiveDependent($client_id=null){
        $me = new static;
        return $me::where('client_id',$client_id)->where('active',true)->count() > 0;
    }
    
    public function activeDependent($client_id){
        $me = new static;
        return $me->where('client_id',$client_id)->where('active',true)->get();
    }
}
