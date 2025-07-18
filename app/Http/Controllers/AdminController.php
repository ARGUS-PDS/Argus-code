<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function formGerarCartao()
    {
        $usuarios = User::all();
        return view('admin.gerar-cartao', compact('usuarios'));
    }

    public function gerarCartao(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        $cartaoCompleto = str_pad(rand(0, 99999999), 8, '0', STR_PAD_LEFT);
        $ultimos4 = substr($cartaoCompleto, -4);

        $user->cartao_seg = $ultimos4;
        $user->save();

        return redirect()->route('admin.cartao')
            ->with('cartao', $cartaoCompleto)
            ->with('user_id', $user->id);
    }

    public function dashboard()
    {
        $produtos_validade = \App\Models\Product::whereNotNull('expiration_date')
            ->whereDate('expiration_date', '>=', now())
            ->whereDate('expiration_date', '<=', now()->addMonths(6))
            ->orderBy('expiration_date')
            ->get(['id', 'description', 'expiration_date']);

        $movimentacoes = \App\Models\Movement::with('product')
            ->orderBy('date', 'desc')
            ->limit(10)
            ->get();

        $produtos_vencidos = \App\Models\Product::whereNotNull('expiration_date')
            ->whereDate('expiration_date', '<', now())
            ->orderBy('expiration_date')
            ->get(['id', 'description', 'expiration_date']);

        $alertas = \Cache::remember('dashboard_alertas', 60, function () {
            $estoqueQuery = "
                SELECT p.id, p.description, p.minimumStock, 
                    COALESCE(SUM(CASE WHEN m.type = 'entrada' THEN m.quantity WHEN m.type = 'saida' THEN -m.quantity ELSE 0 END), 0) as estoque_atual
                FROM products p
                LEFT JOIN movements m ON m.product_id = p.id
                GROUP BY p.id, p.description, p.minimumStock
            ";

            $produtos = collect(\DB::select($estoqueQuery));

            $minimo = $produtos->filter(fn($p) => $p->estoque_atual == $p->minimumStock && $p->estoque_atual > 0);
            $baixo  = $produtos->filter(fn($p) => $p->estoque_atual > 0 && $p->estoque_atual < $p->minimumStock);
            $zerado = $produtos->filter(fn($p) => $p->estoque_atual == 0);

            return [
                'minimo' => $minimo,
                'baixo' => $baixo,
                'zerado' => $zerado,
            ];
        });

        return view('dashboard', [
            'produtos_validade' => $produtos_validade,
            'movimentacoes' => $movimentacoes,
            'produtos_vencidos' => $produtos_vencidos,
            'produtos_estoque_minimo' => $alertas['minimo'],
            'produtos_estoque_baixo' => $alertas['baixo'],
            'produtos_estoque_zerado' => $alertas['zerado'],
        ]);
    }
}
