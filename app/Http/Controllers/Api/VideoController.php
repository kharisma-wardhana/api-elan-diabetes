<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index(): JsonResponse
    {

        try {
            $videos = Video::orderBy('created_at', 'desc')->get();
            return ResponseFormatter::success(
                ['list' => $videos],
                'Successfully Get All Video'
            );
        } catch (\Exception $error) {
            return ResponseFormatter::serverError(message: $error->getMessage());
        }
    }


    public function show(Video $video): JsonResponse
    {
        try {
            return ResponseFormatter::success(
                $video,
                'Successfully Get Detail Video'
            );
        } catch (\Exception $error) {
            return ResponseFormatter::serverError(message: $error->getMessage());
        }
    }
}
