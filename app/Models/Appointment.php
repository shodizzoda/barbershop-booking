<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'barber_id',
        'service_id',
        'appointment_time',
        'status',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function barber()
    {
        return $this->belongsTo(User::class, 'barber_id');
    }
    
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

}
