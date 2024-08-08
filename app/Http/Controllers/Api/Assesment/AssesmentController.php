<?php

namespace App\Http\Controllers\Api\Assesment;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Models\Assesment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssesmentController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        try {
            $data = Assesment::create($request->all());
            return ResponseFormatter::success($data, "Successfully Add Assesment");
        } catch (\Exception $error) {
            return ResponseFormatter::serverError(message: $error->getMessage());
        }
    }
}
