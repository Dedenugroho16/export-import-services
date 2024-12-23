<?php

namespace App\Imports;

use Exception;
use App\Models\Clients;
use App\Models\ClientCompany;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientsImport implements ToCollection, WithHeadingRow
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
                // Periksa apakah klien sudah ada berdasarkan nama
                $existingClient = Clients::where('name', $row['name'])->first();

                if ($existingClient) {
                    // Jika klien sudah ada, tambahkan ke hasil exists
                    $this->results['exists'][] = $row['name'];
                    continue;
                }

                // Buat klien baru
                $client = Clients::create([
                    'name' => $row['name']
                ]);

                // Proses data perusahaan klien
                $clientCompanies = explode(',', $row['client_companies']);
                $clientCompanies = array_map('trim', $clientCompanies); // Hilangkan spasi

                // Validasi apakah perusahaan klien ada di database
                $existingCompanies = ClientCompany::whereIn('id', $clientCompanies)->pluck('id')->toArray();

                if (count($existingCompanies) !== count($clientCompanies)) {
                    throw new Exception("Beberapa perusahaan tidak ditemukan untuk klien: " . $row['name']);
                }

                // Simpan relasi ke tabel pivot
                $client->clientCompanies()->sync($existingCompanies);

                // Tambahkan ke hasil sukses
                $this->results['success'][] = $row['name'];

            } catch (Exception $e) {
                // Tangani kesalahan dan tambahkan ke hasil gagal
                $this->results['failed'][] = [
                    'name' => $row['name'] ?? null,
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
