<?php

namespace App\Http\Controllers\Api\Assesment;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Models\Antropometri;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AntropometriController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {
            $data = Antropometri::create($request->all());
            return ResponseFormatter::success($data, "Successfully Add Antropometri");
        } catch (\Exception $error) {
            return ResponseFormatter::serverError(message: $error->getMessage());
        }
    }
}
