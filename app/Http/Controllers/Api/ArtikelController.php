<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Models\Artikel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'image' => 'required|mimes:jpg,jpeg,png|max:2048',
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return ResponseFormatter::clientError($validator->errors() . 'Failed Add File Image');
            }

            // Handle the file upload
            if ($request->file('image')) {
                $file = $request->file('image');
                $path = $file->store('uploads', 'public');
            }

            $article = Artikel::create([
                'judul' => $request->get('judul'),
                'content' => $request->get('content'),
                'image' => $path,
            ]);

            return ResponseFormatter::success(
                $article,
                'Successfully Add Artikel'
            );
        } catch (\Exception $error) {
            return ResponseFormatter::serverError(message: $error->getMessage());
        }
    }
}
