<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Models\Kalori;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KaloriController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $calories = Kalori::get();
            return ResponseFormatter::success(
                ["list" => $calories],
                "Successfully Get List Kalori"
            );
        } catch (\Exception $error) {
            return ResponseFormatter::serverError(message: $error->getMessage());
        }
    }

    public function show(Kalori $kalori): JsonResponse
    {
        try {
            return ResponseFormatter::success($kalori, "Successfully Get Detail Kalori");
        } catch (\Exception $error) {
            return ResponseFormatter::serverError(message: $error->getMessage());
        }
    }
}
