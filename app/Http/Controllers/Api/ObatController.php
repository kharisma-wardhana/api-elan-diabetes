<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ResponseFormatter;
use App\Http\Requests\AddObatRequest;
use App\Models\Obat;
use App\Models\User;
use App\Models\UserObat;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ObatController extends Controller
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
            $obats = UserObat::where('users_id', $user->id)
                ->whereRaw("STR_TO_DATE(tanggal, '%Y-%m-%d') BETWEEN ? AND ?", [$startDateFormatted, $endDateFormatted])
                ->get();

            if (isset($date)) {
                $obats = UserObat::where('users_id', $user->id)
                    ->where('tanggal', $dateFormatted)
                    ->get();
            }

            return ResponseFormatter::success(["list" => $obats], "Successfully Get List Obat");
        } catch (\Exception $error) {
            return ResponseFormatter::serverError(message: $error->getMessage());
        }
    }

    public function store(User $user, AddObatRequest $request): JsonResponse
    {
        try {
            $durasi = $request->get('durasi');
            $date = Carbon::parse($request->get('tanggal'));
            for ($i = 0; $i < $durasi; $i++) {
                UserObat::create([
                    'users_id' => $user->id,
                    'nama' => $request->get('nama'),
                    'dosis' => $request->get('dosis'),
                    'type' => $request->get('type'),
                    'tanggal' => $i == 0 ? $date->format('Y-m-d') : $date->addDay()->format('Y-m-d'),
                ]);
            }


            $obats = UserObat::where('users_id', $user->id)
                ->where('tanggal', $request->get('tanggal'))
                ->get();

            return ResponseFormatter::success(['list' => $obats], "Successfully Add Obat");
        } catch (\Exception $error) {
            return ResponseFormatter::serverError(message: $error->getMessage());
        }
    }
}
