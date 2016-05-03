<?php

class School extends BaseModel {
	
	public $timestamps=false;

 	protected $fillable = ['*'];


    public static function getall() {
        $rs=School::orderBy('type')->orderBy('name')->get();
        $r['']='请选择';
        foreach ($rs as $row) {
            $r[$row->id]=$row->name;
        }
        return (array)$r;
    }


	
	public function user() {
		return $this->belongsTo('User');
	}
	

}