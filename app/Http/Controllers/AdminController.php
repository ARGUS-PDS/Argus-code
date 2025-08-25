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

        $lotes_validade = \App\Models\Batch::whereNotNull('expiration_date')
            ->whereDate('expiration_date', '>', now())
            ->orderBy('expiration_date')
            ->get(['batch_code', 'expiration_date']);

        $lotes_validade_proximas = \App\Models\Batch::whereNotNull('expiration_date')
            ->whereDate('expiration_date', '>=', now()) // ainda não venceu
            ->whereDate('expiration_date', '<=', now()->addMonths(2)) // até 2 meses a partir de hoje
            ->orderBy('expiration_date')
            ->get(['batch_code', 'expiration_date']);


        $alertas = \Cache::remember('dashboard_alertas', 60, function () {
            $estoqueQuery = "
                SELECT p.id, p.description, p.minimumStock, 
                    COALESCE(SUM(CASE 
                        WHEN m.type IN ('entrada', 'inward') THEN m.quantity
                        WHEN m.type IN ('saida', 'outward') THEN -m.quantity
                        ELSE 0 END), 0) as estoque_atual
                FROM products p
                LEFT JOIN movements m ON m.product_id = p.id
                GROUP BY p.id, p.description, p.minimumStock
            ";

            $produtos = collect(\DB::select($estoqueQuery));

            $esgotado_ids = $produtos->filter(fn($p) => (int)$p->estoque_atual === 0)->pluck('id')->all();
            $minimo_ids = $produtos->filter(fn($p) => (int)$p->estoque_atual > 0 && (int)$p->estoque_atual == (int)$p->minimumStock)->pluck('id')->all();
            $baixo_ids = $produtos->filter(fn($p) => (int)$p->estoque_atual > 0 && (int)$p->estoque_atual < (int)$p->minimumStock)->pluck('id')->all();

            $minimo = $produtos->whereIn('id', $minimo_ids)->whereNotIn('id', $esgotado_ids)->values();
            $baixo  = $produtos->whereIn('id', $baixo_ids)->whereNotIn('id', $esgotado_ids)->whereNotIn('id', $minimo_ids)->values();
            $zerado = $produtos->whereIn('id', $esgotado_ids)->values();

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
            'lotes_validade' => $lotes_validade,
            'lotes_validade_proximas' => $lotes_validade_proximas,
            'produtos_estoque_minimo' => $alertas['minimo'],
            'produtos_estoque_baixo' => $alertas['baixo'],
            'produtos_estoque_zerado' => $alertas['zerado'],
        ]);
    }

    public function vendas(Request $request)
    {
        $periodo = $request->get('periodo', 'mes');
        $vendas = collect();

        switch ($periodo) {
            case 'dia':
                // Últimos 7 dias - movimentações de saída (vendas)
                $vendas = \App\Models\Movement::where('type', 'outward')
                    ->where('note', 'like', 'Venda ID:%')
                    ->whereDate('date', '>=', now()->subDays(7))
                    ->selectRaw('DATE(date) as data, SUM(cost * quantity) as total')
                    ->groupBy('data')
                    ->orderBy('data')
                    ->get()
                    ->keyBy('data');

                $vendasCompletas = collect();
                for ($i = 6; $i >= 0; $i--) {
                    $data = now()->subDays($i)->format('Y-m-d');
                    $total = $vendas->get($data, (object)['total' => 0])->total;
                    $vendasCompletas->push([
                        'label' => now()->subDays($i)->format('d/m'),
                        'total' => (float) $total
                    ]);
                }
                $vendas = $vendasCompletas;
                break;

            /*
            case 'semana':
                // Últimas 8 semanas - movimentações de saída (vendas)
                $vendas = \App\Models\Movement::where('type', 'outward')
                    ->where('note', 'like', 'Venda ID:%')
                    ->where('date', '>=', now()->subWeeks(8))
                    ->selectRaw('YEARWEEK(date, 1) as semana, SUM(cost * quantity) as total')
                    ->groupBy('semana')
                    ->orderBy('semana')
                    ->get()
                    ->keyBy('semana');

                // Preenche todas as semanas, mesmo sem vendas
                $vendasCompletas = collect();
                for ($i = 7; $i >= 0; $i--) {
                    $semana = now()->subWeeks($i)->format('o-W');
                    $total = $vendas->get($semana, (object)['total' => 0])->total;
                    $vendasCompletas->push([
                        'label' => 'Sem ' . now()->subWeeks($i)->format('W'),
                        'total' => (float) $total
                    ]);
                }
                $vendas = $vendasCompletas;
                break;
            */
            case 'mes':
                // Últimos 6 meses - movimentações de saída (vendas)
                $vendas = \App\Models\Movement::where('type', 'outward')
                    ->where('note', 'like', 'Venda ID:%')
                    ->where('date', '>=', now()->subMonths(6))
                    ->selectRaw('YEAR(date) as ano, MONTH(date) as mes, SUM(cost * quantity) as total')
                    ->groupBy('ano', 'mes')
                    ->orderBy('ano')
                    ->orderBy('mes')
                    ->get()
                    ->keyBy(function($item) {
                        return $item->ano . '-' . str_pad($item->mes, 2, '0', STR_PAD_LEFT);
                    });

                // Preenche todos os meses, mesmo sem vendas
                $vendasCompletas = collect();
                for ($i = 5; $i >= 0; $i--) {
                    $data = now()->subMonths($i);
                    $chave = $data->format('Y-m');
                    $total = $vendas->get($chave, (object)['total' => 0])->total;
                    $vendasCompletas->push([
                        'label' => $data->format('M/Y'),
                        'total' => (float) $total
                    ]);
                }
                $vendas = $vendasCompletas;
                break;

            case 'ano':
                // Últimos 3 anos - movimentações de saída (vendas)
                $vendas = \App\Models\Movement::where('type', 'outward')
                    ->where('note', 'like', 'Venda ID:%')
                    ->where('date', '>=', now()->subYears(3))
                    ->selectRaw('YEAR(date) as ano, SUM(cost * quantity) as total')
                    ->groupBy('ano')
                    ->orderBy('ano')
                    ->get()
                    ->keyBy('ano');

                // Preenche todos os anos, mesmo sem vendas
                $vendasCompletas = collect();
                for ($i = 2; $i >= 0; $i--) {
                    $ano = now()->subYears($i)->format('Y');
                    $total = $vendas->get($ano, (object)['total' => 0])->total;
                    $vendasCompletas->push([
                        'label' => $ano,
                        'total' => (float) $total
                    ]);
                }
                $vendas = $vendasCompletas;
                break;
        }

        return response()->json($vendas);
    }
}
