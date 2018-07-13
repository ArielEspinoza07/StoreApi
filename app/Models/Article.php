<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;

    protected $table    =   'articles';

    protected $dates    = ['deleted_at'];

    protected $fillable =   array(
        'name',
        'description',
        'price',
        'total_in_shelf',
        'total_in_vault',
        'store_id'
    );

    protected $casts    =   array(
        'id'                =>  'integer',
        'name'              =>  'string',
        'description'       =>  'string',
        'price'             =>  'decimal',
        'total_in_shelf'    =>  'int',
        'total_in_vault'    =>  'int',
        'store_id'          =>  'int'
    );

    protected $hidden   =   array(
        'deleted_at',
    );

    public function store()
    {
        return $this->belongsTo('App\Models\Store');
    }

    public function scopeName($query,$name){
        if($name){
            return $query->where('name','like',"%$name%");
        }

        return $query;
    }
}
