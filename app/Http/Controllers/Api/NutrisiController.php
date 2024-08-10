<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\AddNutrisiRequest;
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
            $month = $request->get('month');
            $year = $request->get('year');

            // Format the month and year for comparison
            $monthFormatted = str_pad($month, 2, '0', STR_PAD_LEFT); // Ensure month is two digits
            $startDate = "$year-$monthFormatted-01"; // Start of the month
            $endDate = Carbon::parse($startDate)->endOfMonth()->format('Y-m-d'); // End of the month
            $startDateFormatted = Carbon::parse($startDate)->format('Y-m-d');
            $endDateFormatted = Carbon::parse($endDate)->format('Y-m-d');

            $nutritions = Nutrisi::where('users_id', $user->id)
                ->whereRaw("STR_TO_DATE(tanggal, '%Y-%m-%d') BETWEEN ? AND ?", [$startDateFormatted, $endDateFormatted])
                ->orderBy('tanggal', 'desc')
                ->orderBy('type', 'asc')
                ->get();

            return ResponseFormatter::success(
                ['list' => $nutritions],
                'Successfully Get List Nutrisi'
            );
        } catch (\Exception $error) {
            return ResponseFormatter::serverError(message: $error->getMessage());
        }
    }


    public function store(AddNutrisiRequest $request): JsonResponse
    {
        try {
            Nutrisi::create($request->all());
            $nutritions = Nutrisi::where('users_id', $request->get("users_id"))
                ->orderBy('tanggal', 'desc')
                ->orderBy('type', 'asc')
                ->get();
            return ResponseFormatter::success(
                ["list" => $nutritions],
                "Successfully Add Nutrisi"
            );
        } catch (\Exception $error) {
            return ResponseFormatter::serverError(message: $error->getMessage());
        }
    }
}
