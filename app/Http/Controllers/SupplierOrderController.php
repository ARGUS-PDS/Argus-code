<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupplierOrderController extends Controller
{
    public function index()
    {
        $pedidos = \App\Models\SupplierOrder::with(['produto', 'fornecedor'])->latest()->paginate(20);

        return view('orders.index', compact('pedidos'));
    }

}
