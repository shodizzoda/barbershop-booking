<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $services = [
            [
                'title' => 'Мужская стрижка',
                'description' => 'Любая прическа на ваше усмотрение',
                'price' => 30,
                'duration_minutes' => 30,
            ],
            [
                'title' => 'Борода',
                'description' => 'Контовка, Разные стили, Полное бритье',
                'price' => 20,
                'duration_minutes' => 20,
            ],
            [
                'title' => 'Комплекс',
                'description' => 'Прическа + Борода',
                'price' => 55,
                'duration_minutes' => 45,
            ],
            [
                'title' => 'Удаление волос лица',
                'description' => 'Очистка вашего лица',
                'price' => 10,
                'duration_minutes' => 15,
            ]
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
