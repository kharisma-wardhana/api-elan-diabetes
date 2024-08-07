<?php

namespace App\Http\Controllers\Api\Assesment;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Models\Ginjal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GinjalController extends Controller
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

            // Query data based on the formatted dates
            $data = Ginjal::where('users_id', $user->id)
                ->whereRaw("STR_TO_DATE(tanggal, '%Y-%m-%d') BETWEEN ? AND ?", [$startDateFormatted, $endDateFormatted])
                ->get();

            return ResponseFormatter::success(
                ["list" => $data],
                'Successfully List Ginjal'
            );
        } catch (\Exception $error) {
            return ResponseFormatter::serverError(message: $error->getMessage());
        }
    }

    public function store(User $user, Request $request): JsonResponse
    {
        try {
            $data = Ginjal::create($request->all());
            return ResponseFormatter::success(
                $data,
                'Successfully Add Ginjal'
            );
        } catch (\Exception $error) {
            return ResponseFormatter::serverError(message: $error->getMessage());
        }
    }
}
