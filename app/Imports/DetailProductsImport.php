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
