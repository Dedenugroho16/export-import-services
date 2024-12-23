<?php

namespace App\Imports;

use Exception;
use App\Models\Commodity;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CommoditiesImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        // dd($rows->all());
        foreach ($rows as $row) {
            try {
                Commodity::create([
                    'name' => $row['name'],
                ]);
            } catch (Exception $e) {
                // Lempar pengecualian dengan pesan error
                throw new Exception('Terjadi kesalahan saat memproses data: ' . $e->getMessage());
            }
        }
    }
}
