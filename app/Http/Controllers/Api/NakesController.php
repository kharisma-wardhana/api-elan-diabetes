<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Models\Nakes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class NakesController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            $doctors = Nakes::where('status', 1)
                ->orderBy('created_at', 'desc')
                ->get();
            return ResponseFormatter::success(
                ['list' => $doctors],
                'Successfully Get All Nakes'
            );
        } catch (\Exception $error) {
            return ResponseFormatter::serverError(message: $error->getMessage());
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'foto' => 'required|mimes:jpg,jpeg,png|max:2048',
            ]);

            // Check if validation fails
            if ($validator->fails()) {
                return ResponseFormatter::clientError($validator->errors() . 'Failed Add File Foto');
            }

            // Handle the file upload
            if ($request->file('foto')) {
                $file = $request->file('foto');
                $path = $file->store('uploads', 'public');
            }

            $doctor = Nakes::create([
                'nama' => $request->get('nama'),
                'foto' => $path,
                'posisi' => $request->get('posisi'),
                'wa' => $request->get('wa'),
                'status' => 1,
            ]);

            return ResponseFormatter::success(
                $doctor,
                'Successfully Add Nakes'
            );
        } catch (\Exception $error) {
            return ResponseFormatter::serverError(message: $error->getMessage());
        }
    }
}
