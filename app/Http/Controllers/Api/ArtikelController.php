<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Models\Artikel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $articles = Artikel::orderBy('created_at', 'desc')->get();
            return ResponseFormatter::success(
                ['list' => $articles],
                'Successfully Get All Artikel'
            );
        } catch (\Exception $error) {
            return ResponseFormatter::serverError(message: $error->getMessage());
        }
    }


    public function show(Artikel $article): JsonResponse
    {
        try {
            return ResponseFormatter::success(
                $article,
                'Successfully Get Detail Artikel'
            );
        } catch (\Exception $error) {
            return ResponseFormatter::serverError(message: $error->getMessage());
        }
    }
}
