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
                                <a class="dropdown-item" href="'.route('consignees.show', $hashId).'">Show</a>
                                <a class="dropdown-item" href="'.route('consignees.edit', $hashId).'">Edit</a>
                                <form action="'.route('consignees.destroy', $hashId).'" method="POST" onsubmit="return confirm(\'Are you sure?\')" style="display:inline;">
                                    '.csrf_field().method_field('DELETE').'
                                    <button type="submit" class="dropdown-item text-danger">Delete</button>
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
