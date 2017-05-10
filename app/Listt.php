<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listt extends Model
{
    /**
     * Get the todos for the blog post.
     */
    public function todos()
    {
        return $this->hasMany('App\Todo');
    }
    /**
     * Get the post that owns the comment.
     */
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    /*
     * Table name
     */
    protected $table = 'lists';

    /*
     * Fillable fields for protecting mass assignment vulnerability
     */
    protected $fillable = [
        'name',
        'user_id'
    ];

}
