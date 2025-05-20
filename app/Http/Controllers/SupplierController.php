<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
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

    public function show($id)
    {
        $supplier = Supplier::with('address')->findOrFail($id);

        return response()->json($supplier);
    }

    public function update(Request $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

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
            'contactPosition2' => 'nullable|string'
        ]);

        $supplier->update($validated);

        return response()->json([
            'message' => 'Fornecedor atualizado com sucesso',
            'supplier' => $supplier
        ]);
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->address()->delete();
        $supplier->delete();

        return response()->json(['message' => 'Fornecedor excluído com sucesso']);
    }
}
