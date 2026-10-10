<?php

namespace App\Controllers;

use App\Models\CustomerModel;

class Customers extends BaseController
{
    private CustomerModel $customers;

    public function __construct()
    {
        $this->customers = new CustomerModel();
    }

    public function index(): string
    {
        return view('customers/index', ['title' => 'Customers', 'customers' => $this->customers->orderBy('full_name')->findAll()]);
    }

    public function new(): string
    {
        return view('customers/form', ['title' => 'Add customer', 'customer' => null]);
    }

    public function create()
    {
        return $this->persist();
    }

    public function edit(int $id)
    {
        $customer = $this->customers->find($id);
        return $customer
            ? view('customers/form', ['title' => 'Edit customer', 'customer' => $customer])
            : redirect()->to('/customers')->with('error', 'Customer not found.');
    }

    public function update(int $id)
    {
        return $this->customers->find($id)
            ? $this->persist($id)
            : redirect()->to('/customers')->with('error', 'Customer not found.');
    }

    public function delete(int $id)
    {
        if (! $this->customers->find($id)) {
            return redirect()->to('/customers')->with('error', 'Customer not found.');
        }

        $this->customers->delete($id);
        return redirect()->to('/customers')->with('success', 'Customer deleted. Existing sales remain in history.');
    }

    private function persist(?int $id = null)
    {
        $emailRule = $id ? "is_unique[customers.email,id,{$id}]" : 'is_unique[customers.email]';
        $rules = [
            'full_name' => 'required|max_length[100]',
            'email' => "required|valid_email|max_length[100]|{$emailRule}",
            'phone' => 'permit_empty|max_length[20]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'full_name' => trim((string) $this->request->getPost('full_name')),
            'email' => strtolower(trim((string) $this->request->getPost('email'))),
            'phone' => trim((string) $this->request->getPost('phone')) ?: null,
        ];

        $id ? $this->customers->update($id, $data) : $this->customers->insert($data);
        return redirect()->to('/customers')->with('success', $id ? 'Customer updated.' : 'Customer added.');
    }
}
