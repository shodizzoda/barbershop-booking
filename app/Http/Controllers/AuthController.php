<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {

    // 1. Валидируем входящие данные
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 2. Ищем пользователя по email
        $user = User::where('email', $request->email)->first();

        // 3. Проверяем, существует ли юзер и совпадает ли пароль
        if(!$user || !Hash::check($request->password, $user->password)){
            throw ValidationException::withMessages([
                'email' => ['Неверный логин или пароль']
            ]);
        }

        // 4. Удаляем старые токены (опционально, чтобы не плодить мусор в базе)
        $user->tokens()->delete();


        // 5. Создаем новый токен для API
        $token = $user->createToken('barbershop-token')->plainTextToken;

        return response()->json([
            'message' => 'Успешная авторизация',
            'token' => $token,
            'user' => $user,
        ]);
    }

    /**
     * Выход (удаление текущего токена)
     */

    public function logout(Request $request)
    {
        // Удаляем тот токен, с помощью которого пришел запрос
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Вы успешно вышли из системы'
        ]);
    }
}
