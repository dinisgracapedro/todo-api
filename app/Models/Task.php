<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'is_completed',
        'user_id',
    ];

    // Relacionamento com User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
