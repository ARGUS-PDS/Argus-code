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
        $product = Product::where('barcode', $request->barcode)->first();

        if (!$product) {
            return response()->json(['error' => 'Produto não encontrado'], 404);
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
                    throw new \Exception('Produto não encontrado: ID ' . $item['product_id']);
                }

                if ($product->currentStock < $item['quantity']) {
                    throw new \Exception('Estoque insuficiente para o produto: ' . $product->description);
                }

                $product->currentStock -= $item['quantity'];
                $product->save();

                SaleItem::create([
                    'sale_id' => $venda->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price']
                ]);

                Movement::create([
                    'product_id' => $product->id,
                    'type' => 'outward', 
                    'date' => now()->toDateString(),
                    'quantity' => $item['quantity'],
                    'cost' => $item['unit_price'], 
                    'note' => 'Venda ID: ' . $venda->id
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