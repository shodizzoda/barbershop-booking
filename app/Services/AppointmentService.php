<?php

namespace App\Services;

use App\Models\Appointment;
use Carbon\Carbon;

class AppointmentService
{
    /**
     * Проверяет, свободен ли барбер в указанное время
     */
    public function isBarberAvailable($barberId, $startTime, $durationMinutes): bool
    {
        $start = Carbon::parse($startTime);
        $end = (clone $start)->addMinutes($durationMinutes);

        // Ищем пересечения в базе для конкретного барбера
        $conflictingAppointment = Appointment::where('barber_id', $barberId)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($start, $end) {
                $query->where('appointment_time', '<', $end)
                      ->whereRaw('DATE_ADD(appointment_time, INTERVAL (SELECT duration_minutes FROM services WHERE services.id = appointments.service_id) MINUTE) > ?', [$start]);
            })
            ->exists();

        // Если конфликтов нет (exists() вернул false), то барбер свободен (возвращаем true)
        return !$conflictingAppointment;
    }
}