<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Models\Nakes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NakesController extends Controller
{
    public function index():JsonResponse 
    {
        $doctors = Nakes::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->get();
        return ResponseFormatter::success(
            ['list' => $doctors],
            'Successfully Get All Nakes'
        );
    }
}
