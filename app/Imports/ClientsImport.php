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
    /**
     * @param Collection $collection
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            try {
                // Buat klien baru
                $client = Clients::create([
                    'name' => $row['name']
                ]);

                // Proses data perusahaan klien
                $clientCompanies = explode(',', $row['client_companies']);
                $clientCompanies = array_map('trim', $clientCompanies); // Hilangkan spasi

                // Validasi apakah perusahaan klien ada di database
                $existingCompanies = ClientCompany::whereIn('id', $clientCompanies)->pluck('id')->toArray();

                // Tambahkan validasi untuk memastikan semua perusahaan ditemukan
                if (count($existingCompanies) !== count($clientCompanies)) {
                    throw new Exception("Beberapa perusahaan tidak ditemukan untuk klien: " . $row['name']);
                }

                // Simpan relasi ke tabel pivot
                $client->clientCompanies()->sync($existingCompanies);

            } catch (Exception $e) {
                // Tangani kesalahan
                throw new Exception('Terjadi kesalahan saat memproses data: ' . $e->getMessage());
            }
        }
    }
}
