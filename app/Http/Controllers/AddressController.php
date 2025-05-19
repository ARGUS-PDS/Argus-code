<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\Supplier;

class AddressController extends Controller
{
    public function store(Request $request)
    {
        // Validação dos dados do fornecedor
        $supplierData = $request->validate([
            'code' => 'required|unique:suppliers',
            'type' => 'required|in:Física,Jurídica',
            'document' => 'required',
            'name' => 'required',
            'distributor' => 'required',
            // Outros campos do fornecedor
        ]);

        // Cria o fornecedor
        $supplier = Supplier::create($supplierData);

        // Validação dos dados do endereço
        $addressData = $request->validate([
            'cep' => 'required|string',
            'place' => 'required|string',
            'number' => 'required|integer',
            'neighborhood' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string|max:2',
            // Outros campos do endereço
        ]);

        // Cria o endereço associado ao fornecedor
        $address = Address::create(array_merge($addressData, ['supplier_id' => $supplier->id]));

        // Retorna uma resposta (você pode ajustar conforme necessário)
        return response()->json([
            'message' => 'Fornecedor e endereço criados com sucesso',
            'supplier' => $supplier,
            'address' => $address,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $address = Address::findOrFail($id);

        $validated = $request->validate([
            'cep' => 'sometimes|required|string',
            'place' => 'sometimes|required|string',
            'number' => 'sometimes|required|integer',
            'neighborhood' => 'sometimes|required|string',
            'city' => 'sometimes|required|string',
            'state' => 'sometimes|required|string|max:2',
        ]);

        $address->update($validated);

        return response()->json([
            'message' => 'Endereço atualizado com sucesso',
            'address' => $address
        ]);
    }

    public function destroy($id)
    {
        $address = Address::findOrFail($id);
        $address->delete();

        return response()->json(['message' => 'Endereço excluído com sucesso']);
    }
}
