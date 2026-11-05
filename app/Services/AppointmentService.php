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


    /**
     * Получить список записей в зависимости от роли пользователя
     */
    public function getAppointmentForUser($user)
    {
        $query = Appointment::with(['barber', 'service', 'client']);

        // Если пользователь — клиент, он видит только свои записи
        if($user->role === 'barber'){
            $query->where('barber_id', $user->id);

        // Если пользователь — барбер, он видит записи, записанные к нему
        }elseif($user->role === 'client'){
            $query->where('user_id', $user->id);
        }
        // Если админ — видит вообще все записи без фильтрации

        return $query->orderBy('appointment_time', 'asc')->get();
    }

    public function cancelAppointment($appointmentId, $user)
    {

        $appointment = Appointment::findOrFail($appointmentId);
        
        // Проверяем безопасность: клиент может отменять только свою запись
        if ($user->role === 'client' && $appointment->user_id !== $user->id){
            throw new \Exception('У вас нет прав на отмену этой записи.', 403);
        }

        // Меняем статус на cancelled
        $appointment->update([
            'status' => 'cancelled'
        ]);


        return $appointment;
    }
}