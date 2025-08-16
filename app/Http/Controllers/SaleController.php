<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Movement;
use DB;

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
                \Log::info('Estoque atualizado: ', ['product_id' => $product->id, 'currentStock' => $product->currentStock]);

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
}
