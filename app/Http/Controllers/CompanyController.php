<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    // Menampilkan daftar perusahaan
    public function index()
    {
        $companies = Company::all(); // Ambil semua data perusahaan
        return view('company.index', compact('companies'));
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
            'company_code' => 'required|string|max:50|unique:companies,company_code',
            'registration_number' => 'nullable|string|max:50',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'phone_number' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'industry' => 'nullable|string|max:255',
            'tax_id' => 'nullable|string|max:50',
            'founded_date' => 'nullable|date',
            'export_license_number' => 'nullable|string|max:50',
            'import_license_number' => 'nullable|string|max:50',
            'bank_account_details' => 'nullable|string',
            'payment_terms' => 'nullable|string|max:255',
            'incoterms' => 'nullable|string|max:50',
            'shipping_agent' => 'nullable|string|max:255',
            'customs_broker' => 'nullable|string|max:255',
            'consignee_code' => 'nullable|string|max:50',
            'forwarding_agent' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Upload logo jika ada
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            // Dapatkan nama asli file
            $originalName = pathinfo($logo->getClientOriginalName(), PATHINFO_FILENAME);
            // Dapatkan ekstensi file
            $extension = $logo->getClientOriginalExtension();
            // Buat nama baru dengan menambahkan timestamp
            $newName = $originalName . '_' . time() . '.' . $extension;
            // Simpan file dengan nama baru
            $logoPath = $logo->storeAs('logos', $newName, 'public');
            $validatedData['logo'] = $logoPath; 
        }
        

        // Simpan data perusahaan
        Company::create($validatedData);

        return redirect()->route('company.index')->with('success', 'Company created successfully!');
    }
}

