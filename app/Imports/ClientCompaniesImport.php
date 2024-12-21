<?php

namespace App\Imports;

use Exception;
use App\Models\ClientCompany;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientCompaniesImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        // dd($rows->all());
        foreach ($rows as $row) {
            try {
                ClientCompany::create([
                    'company_name' => $row['company_name'],
                    'address' => $row['address'],
                    'PO_BOX' => $row['po_box'],
                    'tel' => $row['tel'],
                    'fax' => $row['fax'],
                ]);
            } catch (Exception $e) {
                // Lempar pengecualian dengan pesan error
                throw new Exception('Terjadi kesalahan saat memproses data: ' . $e->getMessage());
            }
        }
    }
}
