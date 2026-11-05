<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    
    protected $fillable = [
        'title',
        'description',
        'price',
        'duration_minutes'
    ];
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
