<?php

namespace App\Imports;

use Exception;
use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToCollection, WithHeadingRow
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
                // Cek apakah produk dengan kode tertentu sudah ada
                $existingProduct = Product::where('code', $row['code'])->first();

                if ($existingProduct) {
                    // Tambahkan ke daftar exist jika produk sudah ada
                    $this->results['exists'][] = [
                        'code' => $row['code'],
                        'name' => $row['name']
                    ];
                    continue;
                }

                // Buat produk baru
                Product::create([
                    'code' => $row['code'],
                    'name' => $row['name'],
                    'abbreviation' => $row['abbreviation'],
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
