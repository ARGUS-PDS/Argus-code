<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::with(['owner', 'address'])->get();
        return view('companies.index', compact('companies'));
    }

    public function create()
    {
        return view('companies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            // Empresa
            'cnpj' => 'required|string|max:18',
            'businessName' => 'required|string|max:50',
            'tradeName' => 'required|string|max:50',
            'stateRegistration' => 'nullable|string|max:15',
            'cep' => 'required|string|max:8',
            'place' => 'required|string|max:100',
            'number' => 'required|integer',
            'neighborhood' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:2',
            // Usuário master
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|string|email|max:255|unique:users,email',
            'user_password' => 'required|string|min:8',
        ], [
            'user_email.unique' => 'Este e-mail já está em uso. Por favor, escolha outro.',
        ]);

        $address = Address::create([
            'cep' => $validated['cep'],
            'place' => $validated['place'],
            'number' => $validated['number'],
            'neighborhood' => $validated['neighborhood'],
            'city' => $validated['city'],
            'state' => $validated['state'],
        ]);

        $user = User::create([
            'name' => $validated['user_name'],
            'email' => $validated['user_email'],
            'password' => Hash::make($validated['user_password']),
            'userType' => 'master',
        ]);

        $cartaoCompleto = str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);
        $user->cartao_seg = substr($cartaoCompleto, -4);
        $user->save();

        Company::create([
            'cnpj' => $validated['cnpj'],
            'businessName' => $validated['businessName'],
            'tradeName' => $validated['tradeName'],
            'stateRegistration' => $validated['stateRegistration'],
            'addressId' => $address->id,
            'user_id' => $user->id,
        ]);

        return redirect()->route('companies.index')
            ->with('success', 'Empresa e usuário master criados com sucesso!');
    }
}