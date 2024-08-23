<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ResponseNutrisi extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Grouping by 'type'
        $grouped = $this->groupBy('type')->map(function ($group, $type) {
            // Calculate total calories
            $totalKalori = $group->sum(function ($item) {
                return (int) filter_var($item['jumlah_kalori'], FILTER_SANITIZE_NUMBER_INT);
            });

            // Format the data
            $data = $group->map(function ($item) {
                return [
                    'id' => $item['id'],
                    'nama' => $item['nama'],
                    'jumlah_kalori' => $item['jumlah_kalori'],
                ];
            })->values();

            return [
                'type' => $type,
                'total' => "{$totalKalori} Kal",
                'data' => $data
            ];
        })->values();

        return [
            'list' => $grouped
        ];
    }
}
