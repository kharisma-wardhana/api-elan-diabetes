<?php

namespace App\Http\Controllers\Api\Assesment;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\AddAktifitasRequest;
use App\Models\Aktifitas;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AktifitasController extends Controller
{
    public function index(User $user, Request $request): JsonResponse
    {
        try {
            $month = $request->get('month');
            $year = $request->get('year');
            $date = $request->get('date');
            $dateFormatted = Carbon::parse($date)->format('Y-m-d');

            // Format the month and year for comparison
            $monthFormatted = str_pad($month, 2, '0', STR_PAD_LEFT); // Ensure month is two digits
            $startDate = "$year-$monthFormatted-01"; // Start of the month
            $endDate = Carbon::parse($startDate)->endOfMonth()->format('Y-m-d'); // End of the month
            $startDateFormatted = Carbon::parse($startDate)->format('Y-m-d');
            $endDateFormatted = Carbon::parse($endDate)->format('Y-m-d');

            $data = Aktifitas::where('users_id', $user->id)
                ->whereRaw("STR_TO_DATE(tanggal, '%Y-%m-%d') BETWEEN ? AND ?", [$startDateFormatted, $endDateFormatted])
                ->limit(5)
                ->orderBy('tanggal', 'desc')
                ->get();

            if (isset($date)) {
                $data = Aktifitas::where('users_id', $user->id)
                    ->where('tanggal', $dateFormatted)
                    ->limit(5)
                    ->get();
            }
            return ResponseFormatter::success(
                ['list' => $data],
                'Successfully Get List Aktfitas'
            );
        } catch (\Exception $error) {
            return ResponseFormatter::serverError(message: $error->getMessage());
        }
    }

    public function store(User $user, AddAktifitasRequest $request): JsonResponse
    {
        try {
            Aktifitas::create($request->all());
            $data = Aktifitas::where('users_id', $user->id)
                ->where('tanggal', $request->get('tanggal'))
                ->limit(5)
                ->get();
            return ResponseFormatter::success(
                ['list' => $data],
                'Successfully Add Aktfitas'
            );
        } catch (\Exception $error) {
            return ResponseFormatter::serverError(message: $error->getMessage());
        }
    }
}
