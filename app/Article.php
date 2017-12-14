<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['title','content'];

    public function tags(){
    	return $this->belongsToMany('App\Tag');
    }

    public function user(){
    	return $this->belongsTo('App\User');
    }
}
