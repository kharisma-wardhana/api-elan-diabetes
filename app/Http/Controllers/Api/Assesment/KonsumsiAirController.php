<?php

namespace App\Http\Controllers\Api\Assesment;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\AddWaterRequest;
use App\Models\KonsumsiAir;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KonsumsiAirController extends Controller
{
    public function index(): JsonResponse
    {
        $waters = KonsumsiAir::where('users_id', 1)->get();
        return ResponseFormatter::success(
            ['list' => $waters],
            'Successfully Get Data Konsumsi Air',
        );
    }

    public function store(AddWaterRequest $request): JsonResponse
    {
        $water = KonsumsiAir::create($request->all());
        return ResponseFormatter::success(
            $water,
            'Successfully Add Konsumsi Air'
        );
    }

    public function update(KonsumsiAir $water, Request $request): JsonResponse
    {
        $water->update($request->all());
        return ResponseFormatter::success(
            $water,
            'Successfully Updated Konsumsi Air'
        );
    }

}
