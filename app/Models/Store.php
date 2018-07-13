<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use SoftDeletes;

    protected $table    =   'stores';

    protected $dates    = ['deleted_at'];

    protected $fillable =   array(
        'name',
        'address'
    );

    protected $casts    =   array(
        'id'        =>  'integer',
        'name'      =>  'string',
        'address'   =>  'string'
    );

    protected $hidden   =   array(
        'deleted_at'
    );

    public function articles()
    {
        return $this->hasMany('App\Models\Article');
    }

    public function scopeName($query,$name){
        if($name){
            return $query->where('name','like',"%$name%");
        }

        return $query;
    }
}
