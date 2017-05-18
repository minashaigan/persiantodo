<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Notifications\UnDoneToDo;

class Todo extends Model
{
    use Notifiable;
    /*
     * Table name
     */
    protected $table = 'todos';
    /**
     * Get the post that owns the comment.
     */

    public function listt()
    {
        return $this->belongsTo('App\Listt','list_id');
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
