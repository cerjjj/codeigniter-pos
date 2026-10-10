<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use App\Models\ProductModel;
use App\Models\SaleModel;
use App\Services\SaleService;
use DomainException;
use Throwable;

class Sales extends BaseController
{
    public function index(): string
    {
        return view('sales/index', ['title' => 'Sales history', 'sales' => (new SaleModel())->history()]);
    }

    public function new(): string
    {
        return view('sales/form', [
            'title' => 'Record sale',
            'products' => (new ProductModel())->where('is_active', 1)->where('stock_quantity >', 0)->orderBy('name')->findAll(),
            'customers' => (new CustomerModel())->orderBy('full_name')->findAll(),
        ]);
    }

    public function create()
    {
        $rules = [
            'product_id' => 'required|is_natural_no_zero',
            'customer_id' => 'permit_empty|is_natural_no_zero',
            'quantity' => 'required|integer|greater_than[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        try {
            (new SaleService())->record(
                (int) $this->request->getPost('product_id'),
                $this->request->getPost('customer_id') ? (int) $this->request->getPost('customer_id') : null,
                (int) session('user_id'),
                (int) $this->request->getPost('quantity')
            );
        } catch (DomainException $exception) {
            return redirect()->back()->withInput()->with('error', $exception->getMessage());
        } catch (Throwable $exception) {
            log_message('error', 'Sale failed: {message}', ['message' => $exception->getMessage()]);
            return redirect()->back()->withInput()->with('error', 'The sale could not be recorded. Please try again.');
        }

        return redirect()->to('/sales')->with('success', 'Sale recorded and inventory updated.');
    }
}
