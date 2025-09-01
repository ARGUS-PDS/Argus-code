<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;
use App\Models\Supplier;

class AddressController extends Controller
{
    public function store(Request $request, $supplierId)
    {
        $supplier = Supplier::findOrFail($supplierId);

        if ($request->has('address') && is_array($request->address)) {
            foreach ($request->address as $addrData) {
                $supplier->address()->create([
                    'cep' => $addrData['cep'] ?? null,
                    'place' => $addrData['place'] ?? null,
                    'number' => $addrData['number'] ?? null,
                    'neighborhood' => $addrData['neighborhood'] ?? null,
                    'city' => $addrData['city'] ?? null,
                    'state' => $addrData['state'] ?? null,
                    'details' => $addrData['details'] ?? null,
                ]);
            }
        }

        return response()->json(['message' => 'Endereços salvos com sucesso']);
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
            'details' => 'nullable|string',
        ]);

        $address->update([
            'cep' => $validated['cep'] ?? $address->cep,
            'place' => $validated['place'] ?? $address->place,
            'number' => $validated['number'] ?? $address->number,
            'neighborhood' => $validated['neighborhood'] ?? $address->neighborhood,
            'city' => $validated['city'] ?? $address->city,
            'state' => $validated['state'] ?? $address->state,
            'details' => $validated['details'] ?? $address->details,
        ]);

        return response()->json([
            'message' => 'Endereço atualizado com sucesso',
            'address' => $address
        ]);
    }
}