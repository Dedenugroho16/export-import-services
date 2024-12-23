<?php

namespace App\Imports;

use Exception;
use App\Models\ClientCompany;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientCompaniesImport implements ToCollection, WithHeadingRow
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
                $clientCompany = ClientCompany::firstOrCreate(
                    ['company_name' => $row['company_name']], // Kondisi pencarian
                    [
                        'company_name' => $row['company_name'],
                        'address' => $row['address'],
                        'PO_BOX' => $row['po_box'],
                        'tel' => $row['tel'],
                        'fax' => $row['fax'],
                    ]
                );

                if ($clientCompany->wasRecentlyCreated) {
                    // Data baru berhasil ditambahkan
                    $this->results['success'][] = $row['company_name'];
                } else {
                    // Data sudah ada
                    $this->results['exists'][] = $row['company_name'];
                }
            } catch (Exception $e) {
                // Data gagal diproses
                $this->results['failed'][] = [
                    'company_name' => $row['company_name'],
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
