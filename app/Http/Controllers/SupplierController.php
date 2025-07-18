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

        $suppliers = $query->paginate(5);

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

            // Endereço
            'address.cep' => 'required|string',
            'address.place' => 'required|string',
            'address.number' => 'required|integer',
            'address.neighborhood' => 'required|string',
            'address.city' => 'required|string',
            'address.state' => 'required|string|max:2',
        ]);

        DB::beginTransaction();

        try {
            // Cria endereço
            $address = \App\Models\Address::create($validated['address']);

            // Cria fornecedor com o ID do endereço
            $supplierData = collect($validated)->except('address')->toArray();
            $supplierData['address_id'] = $address->id;

            $supplier = Supplier::create($supplierData);

            DB::commit();

            return redirect('/lista-fornecedores')->with('success', 'Fornecedor cadastrado com sucesso!');
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

    public function create_barcode() // Ou o método que renderiza a view de cadastro
    {
        $suppliers = Supplier::all(); // Busca todos os fornecedores do banco de dados
        return view('codigo-de-barras', compact('suppliers')); // Passa a variável $suppliers para a view
    }

    public function show($id)
    {
        $supplier = Supplier::with('address')->findOrFail($id);

        return response()->json($supplier);
    }

    // app/Http/Controllers/SupplierController.php

    public function edit($id)
    {
        // Carrega o fornecedor e seu relacionamento 'address'
        $supplier = Supplier::with('address')->findOrFail($id);

        return view('suppliers.edit', compact('supplier'));
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);

        // Opcional: deletar endereço também
        $address = $supplier->address;

        $supplier->delete();

        if ($address) {
            $address->delete();
        }

        return redirect()->route('suppliers.index')->with('success', 'Fornecedor deletado com sucesso.');
    }



    public function update(Request $request, $id)
    {
        $supplier = Supplier::with('address')->findOrFail($id);

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
            // Atualiza dados do fornecedor
            $supplier->update(collect($validated)->except('address')->toArray());

            // Se veio endereço
            if (isset($validated['address'])) {
                if ($supplier->address) {
                    // Atualiza o endereço existente
                    $supplier->address->update($validated['address']);
                } else {
                    // Cria novo endereço e associa
                    $address = \App\Models\Address::create($validated['address']);
                    $supplier->address_id = $address->id;
                    $supplier->save();
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
