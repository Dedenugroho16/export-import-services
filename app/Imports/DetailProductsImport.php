<?php

namespace App\Imports;

use Exception;
use App\Models\DetailProduct;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DetailProductsImport implements ToCollection, WithHeadingRow
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
                // Cek apakah detail produk sudah ada berdasarkan id_product dan name
                $existingDetail = DetailProduct::where('id_product', $row['id_product'])
                    ->where('name', $row['name'])
                    ->first();

                if ($existingDetail) {
                    // Jika sudah ada, tambahkan ke daftar exists
                    $this->results['exists'][] = [
                        'id_product' => $row['id_product'],
                        'name' => $row['name']
                    ];
                    continue;
                }

                // Buat detail produk baru
                DetailProduct::create([
                    'id_product' => $row['id_product'],
                    'name' => $row['name'],
                    'pcs' => $row['pcs'],
                    'dimension' => $row['dimension'],
                    'type' => $row['type'],
                    'color' => $row['color'],
                    'price' => $row['price'],
                ]);

                // Tambahkan ke daftar sukses
                $this->results['success'][] = [
                    'id_product' => $row['id_product'],
                    'name' => $row['name']
                ];
            } catch (Exception $e) {
                // Tangani kesalahan dan tambahkan ke daftar gagal
                $this->results['failed'][] = [
                    'id_product' => $row['id_product'] ?? 'Tidak diketahui',
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
