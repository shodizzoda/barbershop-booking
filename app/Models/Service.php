<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use SoftDeletes;

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
