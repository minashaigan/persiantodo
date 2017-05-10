<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
    /**
     * Get the todos for the blog post.
     */
    public function todos()
    {
        return $this->hasMany('App\Todo');
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
    ];
    
}
