<?php

namespace App\Http\Controllers\Api\Assesment;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\AddWaterRequest;
use App\Models\KonsumsiAir;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KonsumsiAirController extends Controller
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

            // Query data based on the formatted dates
            $waters = KonsumsiAir::where('users_id', $user->id)
                ->whereRaw("STR_TO_DATE(tanggal, '%Y-%m-%d') BETWEEN ? AND ?", [$startDateFormatted, $endDateFormatted])
                ->get();

            if (isset($date)) {
                $waters = KonsumsiAir::where('users_id', $user->id)
                    ->where('tanggal', $dateFormatted)
                    ->get();
            }

            return ResponseFormatter::success(
                ['list' => $waters],
                'Successfully Get List Konsumsi Air',
            );
        } catch (\Exception $error) {
            return ResponseFormatter::serverError(message: $error->getMessage());
        }
    }

    public function store(AddWaterRequest $request): JsonResponse
    {
        try {
            $oldData = KonsumsiAir::where('users_id', $request->get('users_id'))
                ->where('tanggal', $request->get('tanggal'))
                ->first();
            if ($oldData != null) {
                $totalAir = $oldData->jumlah + $request->get('jumlah');
                $water = $oldData->update([
                    'jumlah' => $totalAir
                ]);
            } else {
                $water = KonsumsiAir::create($request->all());
            }
            return ResponseFormatter::success(
                ['list' => KonsumsiAir::where('users_id', $request->get('users_id'))
                    ->where('tanggal', $request->get('tanggal'))
                    ->get()],
                'Successfully Add Konsumsi Air'
            );
        } catch (\Exception $error) {
            return ResponseFormatter::serverError(message: $error->getMessage());
        }
    }

    public function update(KonsumsiAir $water, Request $request): JsonResponse
    {
        try {
            $totalAir = $water->jumlah + $request->get('jumlah');
            $water->update([
                'jumlah' => $totalAir
            ]);
            return ResponseFormatter::success(
                $water,
                'Successfully Updated Konsumsi Air'
            );
        } catch (\Exception $error) {
            return ResponseFormatter::serverError(message: $error->getMessage());
        }
    }
}
