<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();

        // Здесь мы даём в ответ коллекцию прямо с базы
        // А в проф разработке надо использовать API Resources
        // или можно исключать поля в модели с помощью $hidden

        return response()->json([
            'status' => 'success',
            'message' => 'Каталог услуг',
            'data' => $services 
        ]);

    }
}
