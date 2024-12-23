<?php

namespace App\Imports;

use Exception;
use App\Models\Country;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CountriesImport implements ToCollection, WithHeadingRow
{
    public $results = [
        'success' => [],
        'failed' => [],
        'exists' => []
    ];

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                // Cek apakah negara sudah ada berdasarkan kode
                $existingCountry = Country::where('code', $row['code'])->first();

                if ($existingCountry) {
                    // Jika sudah ada, tambahkan ke daftar exists
                    $this->results['exists'][] = [
                        'code' => $row['code'],
                        'name' => $row['name']
                    ];
                    continue;
                }

                // Buat negara baru
                Country::create([
                    'code' => $row['code'],
                    'name' => $row['name'],
                ]);

                // Tambahkan ke daftar sukses
                $this->results['success'][] = [
                    'code' => $row['code'],
                    'name' => $row['name']
                ];
            } catch (Exception $e) {
                // Tangani kesalahan dan tambahkan ke daftar gagal
                $this->results['failed'][] = [
                    'code' => $row['code'] ?? 'Tidak diketahui',
                    'name' => $row['name'] ?? 'Tidak diketahui',
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
