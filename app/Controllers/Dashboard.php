<?php

namespace App\Controllers;

use App\Models\SaleModel;

class Dashboard extends BaseController
{
    public function index(): string
    {
        $db = db_connect();
        $revenue = $db->table('sales')->selectSum('total_price')->get()->getRowArray();

        return view('dashboard/index', [
            'title' => 'Dashboard',
            'productCount' => $db->table('products')->where('is_active', 1)->countAllResults(),
            'customerCount' => $db->table('customers')->countAllResults(),
            'saleCount' => $db->table('sales')->countAllResults(),
            'revenue' => (float) ($revenue['total_price'] ?? 0),
            'lowStock' => $db->table('products')->where('is_active', 1)->where('stock_quantity <=', 10)->orderBy('stock_quantity')->get()->getResultArray(),
            'recentSales' => (new SaleModel())->history(6),
        ]);
    }
}
