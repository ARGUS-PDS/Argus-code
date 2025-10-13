<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Movement;
use DB;
use Carbon\Carbon;

class SaleController extends Controller
{
    public function create()
    {
        return view('sales.create');
    }

    public function findByBarcode(Request $request)
    {
        $query = $request->input('query');

        $product = Product::where('barcode', $query)
            ->orWhere('description', 'like', "%{$query}%")
            ->first();

        if (!$product) {
            // Internacionalização: Produto não encontrado
            return response()->json(['error' => __('sales.product_not_found')], 404);
        }

        return response()->json($product);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $venda = Sale::create([
                'total' => $request->total
            ]);

            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);

                if (!$product) {
                    // Internacionalização: Produto não encontrado: ID
                    $errorMessage = __('sales.product_not_found_id', ['id' => $item['product_id']]);
                    throw new \Exception($errorMessage);
                }

                if ($product->currentStock < $item['quantity']) {
                    // Internacionalização: Estoque insuficiente para o produto:
                    $errorMessage = __('sales.insufficient_stock', ['product' => $product->description]);
                    throw new \Exception($errorMessage);
                }

                $product->currentStock -= $item['quantity'];
                $product->save();

                SaleItem::create([
                    'sale_id' => $venda->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price']
                ]);

                // Internacionalização: Nota do movimento
                $note = __('sales.sale_id_note', ['id' => $venda->id]);

                Movement::create([
                    'product_id' => $product->id,
                    'type' => 'outward',
                    'date' => now()->toDateString(),
                    'quantity' => $item['quantity'],
                    'cost' => $item['unit_price'],
                    'note' => $note
                ]);
            }

            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function vendasPorPeriodo(Request $request)
    {
        $periodo = $request->get('periodo', 'dia');

        $query = Sale::query()
            ->select(DB::raw('SUM(total) as total'));

        switch ($periodo) {
            case 'ano':
                $query->addSelect(DB::raw('YEAR(created_at) as label'))
                    ->groupBy('label');
                break;

            case 'mes':
                $query->addSelect(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as label'))
                    ->groupBy('label');
                break;

            case 'semana':
                $query->addSelect(DB::raw('YEARWEEK(created_at, 1) as label'))
                    ->groupBy('label');
                break;

            case 'dia':
            default:
                $query->addSelect(DB::raw('DATE(created_at) as label'))
                    ->groupBy('label');
                break;
        }

        $dados = $query->orderBy('label')->get();

        return response()->json($dados);
    }
}
