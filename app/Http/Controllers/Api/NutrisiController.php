<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\AddNutrisiRequest;
use App\Http\Resources\ResponseNutrisi;
use App\Models\Nutrisi;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NutrisiController extends Controller
{
    public function index(User $user, Request $request): JsonResponse
    {
        try {
            $date = $request->get('date');
            $dateFormatted = Carbon::parse($date)->format('Y-m-d');

            $nutritions = Nutrisi::where('users_id', $user->id)
                ->where('tanggal', $dateFormatted)
                ->orderBy('type', 'asc')
                ->get();

            return ResponseFormatter::success(
                new ResponseNutrisi($nutritions),
                'Successfully Get List Nutrisi'
            );
        } catch (\Exception $error) {
            return ResponseFormatter::serverError(message: $error->getMessage());
        }
    }


    public function store(User $user, AddNutrisiRequest $request): JsonResponse
    {
        try {
            Nutrisi::create($request->all());
            $nutritions = Nutrisi::where('users_id', $request->get("users_id"))
                ->where('tanggal', $request->get('tanggal'))
                ->orderBy('type', 'asc')
                ->get();
            return ResponseFormatter::success(
                new ResponseNutrisi($nutritions),
                "Successfully Add Nutrisi"
            );
        } catch (\Exception $error) {
            return ResponseFormatter::serverError(message: $error->getMessage());
        }
    }
}
