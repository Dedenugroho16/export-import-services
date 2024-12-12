<?php

namespace App\Imports;

use Exception;
use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToCollection, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                Product::create([
                    'code' => $row['code'],
                    'name' => $row['name'],
                    'abbreviation' => $row['abbreviation'],
                ]);
            } catch (Exception $e) {
                // Lempar pengecualian dengan pesan error
                throw new Exception('Terjadi kesalahan saat memproses data: ' . $e->getMessage());
            }
        }
    }
}
