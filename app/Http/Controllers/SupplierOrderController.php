<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupplierOrderController extends Controller
{
    public function index()
    {
        $pedidos = \App\Models\SupplierOrder::with(['produto', 'fornecedor'])->latest()->get();

        return view('orders.index', compact('pedidos'));
    }

}
