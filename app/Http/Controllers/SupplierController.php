<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{

    public function index(Request $request)
    {
        $query = Supplier::query();

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where('name', 'like', '%' . $q . '%')
                ->orWhere('code', 'like', '%' . $q . '%');
        }

        $suppliers = $query->get();

        return view('suppliers.index', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:FISICA,JURIDICA',
            'document' => 'required|string|unique:suppliers,document',
            'code' => 'nullable|string',
            'distributor' => 'nullable|string',
            'fixedphone' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'contactNumber1' => 'nullable|string',
            'contactName1' => 'nullable|string',
            'contactPosition1' => 'nullable|string',
            'contactNumber2' => 'nullable|string',
            'contactName2' => 'nullable|string',
            'contactPosition2' => 'nullable|string',
            'address' => 'required|array',
            'address.*.cep' => 'required|string',
            'address.*.place' => 'required|string',
            'address.*.number' => 'required|integer',
            'address.*.neighborhood' => 'required|string',
            'address.*.city' => 'required|string',
            'address.*.state' => 'required|string|max:2',
        ]);

        DB::beginTransaction();

        try {
            $supplierData = collect($validated)->except('address')->toArray();
            $supplier = Supplier::create($supplierData);

            foreach ($validated['address'] as $address) {
                $supplier->addresses()->create($address);
            }

            DB::commit();

            return response()->json([
                'message' => 'Fornecedor criado com sucesso',
                'supplier' => $supplier->load('addresses')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'error' => 'Erro ao criar fornecedor',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function create()
    {
        return view('cadastro-fornecedor');
    }

    public function show($id)
    {
        $supplier = Supplier::with('address')->findOrFail($id);

        return response()->json($supplier);
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('suppliers.edit', compact('supplier'));
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect()->route('suppliers.index')->with('success', 'Fornecedor deletado com sucesso.');
    }


    public function update(Request $request, $id)
    {
        $supplier = Supplier::with('addresses')->findOrFail($id);

        // Validação dos dados principais
        $validated = $request->validate([
            'name' => 'sometimes|required|string',
            'type' => 'sometimes|required|in:FISICA,JURIDICA',
            'document' => 'sometimes|required|string|unique:suppliers,document,' . $supplier->id,
            'code' => 'nullable|string',
            'distributor' => 'nullable|string',
            'fixedphone' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'contactNumber1' => 'nullable|string',
            'contactName1' => 'nullable|string',
            'contactPosition1' => 'nullable|string',
            'contactNumber2' => 'nullable|string',
            'contactName2' => 'nullable|string',
            'contactPosition2' => 'nullable|string',

            // Endereço
            'address' => 'nullable|array',
            'address.cep' => 'nullable|string',
            'address.place' => 'nullable|string',
            'address.number' => 'nullable|integer',
            'address.neighborhood' => 'nullable|string',
            'address.city' => 'nullable|string',
            'address.state' => 'nullable|string|max:2',
        ]);

        DB::beginTransaction();

        try {
            // Atualiza os dados do fornecedor
            $supplier->update(collect($validated)->except('address')->toArray());

            // Verifica se veio endereço
            if (isset($validated['address'])) {
                $addressData = $validated['address'];

                if ($supplier->addresses->isNotEmpty()) {
                    // Se já tem endereço, atualiza o primeiro (ou adapte para vários)
                    $supplier->addresses->first()->update($addressData);
                } else {
                    // Se não tem, cria um novo
                    $supplier->addresses()->create($addressData);
                }
            }

            DB::commit();

            return redirect()->route('suppliers.index')->with('success', 'Fornecedor atualizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors('Erro ao atualizar fornecedor: ' . $e->getMessage());
        }
    }
}
