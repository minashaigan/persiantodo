<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    /*
     * Table name
     */
    protected $table = 'todos';
    /**
     * Get the post that owns the comment.
     */

    public function listt()
    {
        return $this->belongsTo('App\List','list_id');
    }
    /*
     * Fillable fields for protecting mass assignment vulnerability
     */
    protected $fillable = [
        'name',
        'context',
        'file',
        'date',
        'rate',
        'list_id'
];

    /*
     * Eloquent attribute casting
     */
    protected $casts = [
        'complete' => 'boolean',
    ];
}
