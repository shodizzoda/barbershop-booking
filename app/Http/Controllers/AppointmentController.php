<?php

namespace App\Http\Controllers;

use App\Http\Requests\AppointmentStoreRequest;
use App\Models\Appointment;
use App\Models\Service;
use App\Services\AppointmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    protected $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    public function store(AppointmentStoreRequest $request)
    {
        // Получаем услугу, чтобы узнать её длительность
        $service = Service::findOrFail($request->service_id);
     
        // Используем наш сервис для проверки, свободен ли барбер
        $isAvailable = $this->appointmentService->isBarberAvailable($request->barber_id, $request->appointment_time, $service->duration_minutes);

        if(!$isAvailable){
            return response()->json([
                'message' => 'Извините, это время уже занято у выбранного барбера. Выберите другой слот'
            ], 422);
        }

        // Если всё чисто, создаем запись в базе
        $appointment = Appointment::create([
            'user_id' => Auth::user()->id, // ID авторизованного клиента
            'barber_id' => $request->barber_id,
            'service_id' => $request->service_id,
            'appointment_time' => $request->appointment_time,
            'status' => 'pending', // Статус по умолчанию
        ]);
        return response()->json([
            'message' => 'Запись успешно создана',
            'appointment' => $appointment,
        ], 201);

    }

    public function index(Request $request)
    {
        $user = $request->user();

        $appointment = $this->appointmentService->getAppointmentForUser($user);

        return response()->json([
            'status' => 'success',
            'count'  => $appointment->count(),
            'data'   => $appointment
        ]);
    }

    public function cancel(Request $request, $id)
    {
        $user = $request->user();


        $cancelledAppointment = $this->appointmentService->cancelAppointment($id, $user);

        return response()->json([
            'status' => 'success',
            'message' => 'Запись успешно отменена',
            'data'   => $cancelledAppointment
        ]);
    }
}
