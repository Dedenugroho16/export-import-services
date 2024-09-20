<?php

namespace App\Http\Controllers;

use App\Models\Consignee;
use App\Models\Client;
use App\Helpers\IdHashHelper;
use Illuminate\Http\Request;
use DataTables;

class ConsigneesController extends Controller
{
    public function index(Request $request)
    {
        // Cek apakah request datang melalui AJAX (dari DataTables)
        if ($request->ajax()) {
            $consignees = Consignee::with('client')->select('consignees.*');
            return DataTables::of($consignees)
                ->addColumn('action', function($row){
                    // Encode ID untuk keamanan
                    $hashId = IdHashHelper::encode($row->id);

                    // Generate action buttons
                    $actionBtn = '
                        <div class="dropdown">
                            <button class="btn btn-success dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                Aksi
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="'.route('consignees.show', $hashId).'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-arrow-up-right me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 7l-10 10" /><path d="M8 7l9 0l0 9" /></svg>
                                    Show
                                </a>
                                <a class="dropdown-item" href="'.route('consignees.edit', $hashId).'">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-edit me-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" /><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" /><path d="M16 5l3 3" /></svg>
                                     Edit
                                </a>
                                <form action="'.route('consignees.destroy', $hashId).'" method="POST" onsubmit="return confirm(\'Are you sure?\')" style="display:inline;">
                                    '.csrf_field().method_field('DELETE').'
                                    <button type="submit" class="dropdown-item text-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icon-tabler-trash me-1"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                     Delete
                                 </button>
                                </form>
                            </div>
                        </div>';
                    
                    return $actionBtn;
                })
                ->editColumn('id_client', function($row) {
                    // Tampilkan nama client terkait, jika ada
                    return $row->client ? $row->client->name : 'N/A';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('consignees.index');
    }

    public function create()
    {
        $clients = Client::all();
        return view('consignees.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'tel' => 'required|string|max:20',
            'id_client' => 'required|exists:clients,id',
        ]);

        Consignee::create($request->all());

        return redirect()->route('consignees.index')->with('success', 'Consignee created successfully.');
    }

    public function edit($hash)
    {
        $id = IdHashHelper::decode($hash);
        $consignee = Consignee::findOrFail($id);
        $clients = Client::all();
        return view('consignees.edit', compact('consignee', 'clients'));
    }

    public function update(Request $request, $hash)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'tel' => 'required|string|max:20',
            'id_client' => 'required|exists:clients,id',
        ]);

        $id = IdHashHelper::decode($hash);
        $consignee = Consignee::findOrFail($id);
        $consignee->update($request->all());

        return redirect()->route('consignees.index')->with('success', 'Consignee updated successfully.');
    }

    public function show($hash)
    {
        $id = IdHashHelper::decode($hash);
        $consignee = Consignee::with('client')->findOrFail($id);
        return view('consignees.show', compact('consignee'));
    }

    public function destroy($hash)
    {
        $id = IdHashHelper::decode($hash);
        $consignee = Consignee::findOrFail($id);
        $consignee->delete();

        return redirect()->route('consignees.index')->with('success', 'Consignee deleted successfully.');
    }
}
