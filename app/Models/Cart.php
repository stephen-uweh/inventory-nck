<?php

namespace App\Models;

use App\Traits\UuidGenerator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory, UuidGenerator;

    protected $guarded = [];

    protected $casts = [
        'items' => 'array'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'user_id',
        'id',
        'active'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

}
