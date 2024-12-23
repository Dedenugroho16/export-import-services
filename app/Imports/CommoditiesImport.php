<?php

namespace App\Imports;

use Exception;
use App\Models\Commodity;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CommoditiesImport implements ToCollection, WithHeadingRow
{
    public $results = [
        'success' => [],
        'exists' => [],
        'failed' => []
    ];

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                // Cek apakah data sudah ada
                $commodity = Commodity::firstOrCreate(
                    ['name' => $row['name']],
                    ['name' => $row['name']]
                );

                if ($commodity->wasRecentlyCreated) {
                    // Data baru berhasil ditambahkan
                    $this->results['success'][] = $row['name'];
                } else {
                    // Data sudah ada
                    $this->results['exists'][] = $row['name'];
                }
            } catch (Exception $e) {
                // Data gagal diproses
                $this->results['failed'][] = [
                    'name' => $row['name'],
                    'error' => $e->getMessage()
                ];
            }
        }
    }

    public function getResults()
    {
        return $this->results;
    }
}
