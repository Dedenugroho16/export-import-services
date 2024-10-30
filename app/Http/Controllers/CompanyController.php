<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    // Menampilkan daftar perusahaan
    public function index()
    {
        // Ambil semua data perusahaan
        $companies = Company::all();

        // Jika ada data, ambil perusahaan pertama
        $companyExists = $companies->isNotEmpty(); // Cek apakah sudah ada data di tabel
        $company = $companies->first(); // Ambil perusahaan pertama jika ada

        // Kirim ke view dengan flag 'companyExists' dan data 'company'
        return view('company.index', compact('companies', 'companyExists', 'company'));
    }

    // Menampilkan form untuk input data perusahaan
    public function create()
    {
        return view('company.create');
    }

    // Menyimpan data perusahaan ke database
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'company_name' => 'required|string|max:255',
            'registration_number' => 'nullable|string|max:50',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:50',
            'founded_date' => 'nullable|date',
            'export_license_number' => 'nullable|string|max:50',
            'import_license_number' => 'nullable|string|max:50',
            'bank_account_details' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Upload logo jika ada
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public'); // Simpan di folder storage/logos
            $validatedData['logo'] = $logoPath; // Simpan path logo
        }

        // Simpan data perusahaan
        Company::create($validatedData);

        return redirect()->route('company.index')->with('success', 'Company created successfully!');
    }

    public function edit($id) {
        $company = Company::findOrFail($id);
        return response()->json($company);
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'company_name' => 'required|string|max:255',
            'registration_number' => 'nullable|string|max:100',
            'address' => 'required|string|max:500',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:100',
            'founded_date' => 'nullable|date',
            'export_license_number' => 'nullable|string|max:100',
            'import_license_number' => 'nullable|string|max:100',
            'bank_account_details' => 'nullable|string|max:500',
            'logo' => 'nullable|image|max:2048', // max 2MB image file
        ]);

        // Cari perusahaan berdasarkan ID
        $company = Company::findOrFail($id);

        // Jika ada logo yang di-upload, simpan file dan update path-nya
        if ($request->hasFile('logo')) {
            // Hapus logo lama jika ada
            if ($company->logo && file_exists(storage_path('app/public/' . $company->logo))) {
                unlink(storage_path('app/public/' . $company->logo));
            }

            // Simpan file logo baru
            $logoPath = $request->file('logo')->store('logos', 'public');
            $company->logo = $logoPath;
        }

        // Update data perusahaan dengan data baru dari request
        $company->update([
            'company_name' => $request->company_name,
            'registration_number' => $request->registration_number,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'postal_code' => $request->postal_code,
            'phone_number' => $request->phone_number,
            'email' => $request->email,
            'website' => $request->website,
            'tax_id' => $request->tax_id,
            'founded_date' => $request->founded_date,
            'export_license_number' => $request->export_license_number,
            'import_license_number' => $request->import_license_number,
            'bank_account_details' => $request->bank_account_details,
        ]);

        // Redirect ke halaman yang diinginkan setelah berhasil update
        return redirect()->route('company.index')->with('success', 'Data perusahaan berhasil diperbarui.');
    }
}