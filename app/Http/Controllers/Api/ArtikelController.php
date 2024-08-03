<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Models\Artikel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ArtikelController extends Controller
{
    public function index() :JsonResponse
    {
        $articles = Artikel::orderBy('created_at', 'desc')->get();
        return ResponseFormatter::success(
            ['list' => $articles],
            'Successfully Get All Artikel'
        );
    }


    public function show(Artikel $article):JsonResponse
    {
        return ResponseFormatter::success(
            $article,
            'Successfully Get Detail Artikel'
        );
    }


}
