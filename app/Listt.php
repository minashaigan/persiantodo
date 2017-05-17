<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Listt extends Model
{
    /*
     * Table name
     */
    protected $table = 'lists';

    /**
     * Get the todos for the blog post.
     */
    public function todos()
    {
        return $this->hasMany('App\Todo','list_id');
    }
    /**
     * Get the post that owns the comment.
     */
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    /*
     * Fillable fields for protecting mass assignment vulnerability
     */
    protected $fillable = [
        'name',
        'user_id'
    ];

}
