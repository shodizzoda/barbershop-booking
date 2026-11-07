<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceStoreRequest;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{


    /**
     * Store a newly created resource in storage.
     */
    public function store(ServiceStoreRequest $request)
    {

        $data = $request->validated();

        $service = Service::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Услуга успешно создана',
            'data' => $service
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ServiceStoreRequest $request, string $id)
    {
        $data = $request->validated();

        $item = Service::find($id);

        if (!isset($item)) {
            return response()->json([
                'status' => 'failed',
                'message' => "Услуга с ID - {$id} не найдена",
            ], 404);
        }

        $item->update($data);

        return response()->json([
            'status' => 'success',
            'message' => 'Услуга изменена',
            'service' => $item
        ]);
    }

    public function destroy(string $id)
    {
        $item = Service::find($id);

        if (!isset($item)) {
            return response()->json([
                'status' => 'failed',
                'message' => "Услуга с ID - {$id} не найдена",
            ], 404);
        }

        $item->delete();

        return response()->json([
            'status' => 'success',
            'message'=> "Услуга с ID - {$id} была удалена",
        ], 200);
    }
}
