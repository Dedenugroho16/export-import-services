<?php

namespace App\Imports;

use Exception;
use App\Models\DetailProduct;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DetailProductsImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                DetailProduct::create([
                    'id_product' => $row['id_product'],
                    'name' => $row['name'],
                    'pcs' => $row['pcs'],
                    'dimension' => $row['dimension'],
                    'type' => $row['type'],
                    'color' => $row['color'],
                    'price' => $row['price'],
                ]);
            } catch (Exception $e) {
                // Lempar pengecualian dengan pesan error
                throw new Exception('Terjadi kesalahan saat memproses data: ' . $e->getMessage());
            }
        }
    }
}
